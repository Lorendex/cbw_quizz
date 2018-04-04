<?php
define('CBW_QUIZZ', TRUE);

require_once "base.inc.php";
if(!isset($_GET)) return "ERROR:NO_PARAMETERS";
$action = $_GET["action"];

switch (strtolower($action)){
    case "savename": {
        $username = htmlspecialchars(trim($_GET["username"]));
        if(!empty($username)) {
            $user->setUsernameAndSave($username);
        } else {
            die("ERROR:NO_USERNAME");
        }
        if(isset($_GET["save_name"]) && $_GET["save_name"] == 1){
            setcookie(config::getInstance()->getCookieName(), $username, time()+3600*24*30);
        }
        echo "OK";
    } break;

    case "noname": {
        setcookie("CBW_NO_NAME", 1, time()+3600*24*30);
        echo "OK";
    } break;

    case "nextquestion": {
        //todo: check current quizz type
        $question = quizz_question::randomQuestion();
        echo $question->generateHTML();
    } break;

    case "checkquizz": {
        if(!isset($_GET["qid"]) || !isset($_GET["area"]) || !isset($_GET["qtype"])) {
            echo "ERROR:CHECK_QUIZZ:MISSING_PARAMETERS";
        }
        $qid = intval($_GET["qid"]);
        $area = intval($_GET["area"]);
        $qtype = intval($_GET["qtype"]);

        $given_answers = [];
        if(strpos($_GET["answers"], ":")){
            $tmp = explode(':',$_GET["answers"]);
            foreach($tmp as $val){
                $given_answers[] = intval($val);
            }
        }  else {
            $given_answers[] = $_GET["answers"];
        }

        if($qid === 0) {
            echo "ERROR:CHECK_QUIZZ:QID=0";
            return;
        }

        $question = quizz_question::findByID($qid);
        if($question === null){
            echo "ERROR:CHECK_QUIZZ:QUESTION_NOT_FOUND:QUID=".$qid;
            return;
        }
        $correct_answers = $question->getAnswers();
        $correct_id = [];
        foreach($correct_answers as $correct){
            /**
             * @var $correct quizz_answer
             */
            if($correct->isCorrect()){
                $correct_id[] = $correct->getId();
            }
        }
        sort($correct_id);
        sort($given_answers);
        $diff = array_diff($correct_id, $given_answers);
        if(count($diff) == 0) {
            echo "OK";

            break;
        } else {
            echo "NO::". implode(':',$correct_id);
            break;
        }
    } break;

    case "adminquizz": {
        $output = file_get_contents("template/quizz/question.admin.template.html");
        $all_questions = quizz_question::findAll();

        $list = <<<EOF1
        <table class="table table-striped table-bordered table-hover table-sm">
          <thead>
            <tr>
              <th class="tbl_row_1">#</th>
              <th class="tbl_row_2">ID</th>
              <th class="tbl_row_3">Frage</th>
              <th class="tbl_row_4">Jahr</th>
              <th class="tbl_row_5">Aktionen</th>
            </tr>
          </thead>
          <tbody>
EOF1;
        foreach($all_questions as $question) {
            /** @var $question quizz_question */
            $id=$question->getId();
            $txt=$question->getQuestionText();
            $year =$question->getFromYear() . " ";
            $year.=($question->isFromSummer())? "Sommer" : "Winter";
            $list .= <<<EOF2
            <tr>
              <td class="tbl_row_1"><input type="checkbox" id="$id" class="question_row"></td>
              <td class="tbl_row_2">$id</td>
              <td class="tbl_row_3">$txt</td>
              <td class="tbl_row_4">$year</td>
              <td class="tbl_row_5">
                <i id="$id" class="far fa-edit question_edit"></i>
                <i id="$id" class="far fa-trash-alt question_delete"></i>
                <i id="$id" class="far fa-eye-slash question_hide d-none"></i>
                <i id="$id" class="fas fa-eye question_show d-none"></i>
              </td>
            </tr>
EOF2;
        }
        
        $list .= <<<EOF3
          </tbody>
        </table>
EOF3;

    $output = str_replace("{question_list}", $list, $output);
    echo $output;

    } break;
    case "editquestionform": {
        if(!isset($_GET["qid"])) die("ERROR:NO_QID_RECIVED");
        $output = file_get_contents("template/quizz/question.form.template.html");
        $output = str_replace("{edit_question}", '<input type="hidden" id="qid" value="{qid}">', $output);
        $output = str_replace("{qid", $_GET["qid"], $output);
        echo $output;
    } break;
    case "addquestionform":{
      $output = file_get_contents("template/quizz/question.form.template.html");
      $output = str_replace("{edit_question}", "", $output);
      echo $output;
    } break;
    case "getanswers":{
        if(!isset($_GET["qid"])) die("ERROR:NO_QID_RECIVED");
        $answers = quizz_answer::findByQuestionID($_GET["qid"]);
        $output = "";
        foreach ($answers as $answer) {
            /** @var $answer quizz_answer */
            $output .= $answer->getId() . "||"
                    . $answer->getText() . "||"
                    . $answer->isCorrect()  . "||"
                    . $answer->isDeleted() . PHP_EOL;
        }
        echo $output;
    } break;
    case "addquestion":{
        if(!isset($_POST) || empty($_POST["input_data"])) die("ERROR:NO_DATA_RECIVED");
        $input = $_POST["input_data"];
        $lines = explode("\n",$input);
        $values = [];
        foreach($lines as $line) {
            if(empty($line))
                continue;
            if(strpos($line, "{num}"))
                continue;
            $tmp = explode('||', $line);
            $values[$tmp[0]] = $tmp[1];
        }
        $question = new quizz_question();
        $question->setQuestionText($values["question_text"]);
        $question->setFromYear($values["question_year"]);
        $question->setMoreinfo($values["moreinfo"]);
        $question->setFromSummer($values["question_summer"]);
        $question->setDeleted(0);
        $question->setArea(intval($values["area"]));
        $question->setType(intval($values["type"]));
        $question = quizz_question::create($question);

        foreach($values as $k => $v) {
            if(substr($k, 0, 6) === "answer"){
                $id = explode("_", $k)[1];
                $is_correct = $values["correct_".$id];
                $answer = new quizz_answer();
                $answer->setDeleted(false);
                $answer->setText($v);
                $answer->setQuestionId($question->getId());
                $answer->setCorrect(boolval($is_correct));
                $answer = quizz_answer::create($answer);
            }
        }
        echo "OK";
    } break;
    default: echo "ERROR:UNKNOWN_ACTION"; break;
}

