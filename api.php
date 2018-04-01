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

    default: echo "ERROR:UNKNOWN_ACTION"; break;
}