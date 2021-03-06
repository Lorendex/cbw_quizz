<?php
/**
 * Created: 28/03/2018 10:12
 */

class quizz_question implements db_entry
{
    public const TABLE = "quizz_questions";

    /** @var int */
    private $id;

    /** @var string */
    private $question_title;

    /** @var string */
    private $question_text;

    /** @var quizz_answer[] */
    private $answers = [];

    /** @var int */
    private $type;

    /** @var int */
    private $area;

    /** @var int */
    private $from_year;

    /** @var bool */
    private $from_summer;

    /** @var bool */
    private $deleted;

    /** @var string */
    private $moreinfo;

    /** quizz_question constructor */
    public function __construct() {
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /** @param int $id */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /** @return string */
    public function getQuestionTitle(): string {
        return "" . $this->question_title;
    }

    /** @param string $question_title */
    public function setQuestionTitle(string $question_title): void {
        $this->question_title = "" . $question_title;
    }

    /** @return quizz_answer[] */
    public function getAnswers(): array {
        return quizz_answer::findByQuestionID($this->getId());
    }

    /** @param quizz_answer[] $answers */
    public function setAnswers(array $answers): void {
        $this->answers = $answers;
    }

    /** @return int */
    public function getType(): int {
        return $this->type;
    }

    /** @param int $type */
    public function setType(int $type): void {
        $this->type = $type;
    }

    /** @return int */
    public function getArea(): int {
        return $this->area;
    }

    /** @param quizz_question_area $area */
    public function setArea(int $area): void {
        $this->area = $area;
    }

    /** @return string */
    public function getQuestionText(): string {
        return $this->question_text;
    }

    /** @param string $question_text */
    public function setQuestionText(string $question_text): void {
        $this->question_text = $question_text;
    }

    /**
     * @return int
     */
    public function getFromYear(): int {
        return $this->from_year;
    }

    /**
     * @param int $from_year
     */
    public function setFromYear(int $from_year): void {
        $this->from_year = $from_year;
    }

    /**
     * @return bool
     */
    public function isFromSummer(): bool {
        return $this->from_summer;
    }

    /**
     * @return int
     */
    public function isFromSummerInt(): int {
        return $this->from_summer ? 1 : 0;
    }
    /**
     * @param bool $from_summer
     */
    public function setFromSummer(bool $from_summer): void {
        $this->from_summer = $from_summer;
    }

    /**
     * @return string
     */
    public function getMoreinfo(): string {
        return $this->moreinfo;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted): void {
        $this->deleted = $deleted;
    }

    /**
     * @param string $moreinfo
     */
    public function setMoreinfo(string $moreinfo): void {
        $this->moreinfo = $moreinfo;
    }



    public function generateHTML(){
        $template = file_get_contents("template/quizz/question.template.html");
        $template = str_replace("{title}", $this->getQuestionTitle(), $template);
        $template = str_replace("{question}", $this->getQuestionText(), $template);
        $template = str_replace("{answers}", $this->generateAnswerHTML(), $template);
        $template = str_replace("{id}", $this->getId(), $template);
        $template = str_replace("{area}", $this->getArea(), $template);
        $template = str_replace("{type}", $this->getType(), $template);
        return $template;
    }

    private function generateAnswerHTML(){
        $answers = [];
        if($this->type === quizz_question_type::Select){
            $template = file_get_contents("template/quizz/question.select.template.html");
            foreach($this->getAnswers() as $k => $v) {
                /**
                 * @var $k int
                 * @var $v quizz_answer
                 */
                $current = str_replace("{answer_text}", $v->getText(), $template);
                $current = str_replace("{answer_checkbox_id}", "answer_".$k, $current);
                $current = str_replace("{answer_val}", $v->getId(), $current);
                $answers[] = $current;
            }
        }

        if($this->type === quizz_question_type::Option){
            $template = file_get_contents("template/quizz/question.option.template.html");
            foreach($this->getAnswers() as $k => $v) {
                /**
                 * @var $k int
                 * @var $v quizz_answer
                 */
                $current = str_replace("{answer_text}", $v->getText(), $template);
                $current = str_replace("{answer_checkbox_id}", "answer_".$k, $current);
                $current = str_replace("{answer_val}", $v->getId(), $current);
                $current = str_replace("{answer_group}", "answer_".$this->getId(), $current);
                $answers[] = $current;
            }
        }

        # randomize answer order
        shuffle($answers);
        $output = "";
        foreach($answers as $a){
            $output .= $a . PHP_EOL;
        }
        return $output;
    }

    /**
     * @param array $data
     * @return quizz_question
     */
    public static function fromDB(array $data): quizz_question{
        if(!is_array($data)) return null;
        $inst = new self();
        $inst->setId($data["ID"]);
        $inst->setArea($data["area"]);
        $inst->setType($data["type"]);
        $inst->setQuestionTitle($data["title"]);
        $inst->setQuestionText($data["question"]);
        $inst->setFromSummer(boolval($data["summer"]));
        $inst->setFromYear($data["from_year"]);
        $inst->setMoreinfo($data["moreinfo"]);
        $inst->setDeleted(boolval($data["deleted"]));
        return $inst;
    }

    /**
     * @param int $id
     * @return quizz_question | null
     */
    public static function findByID(int $id): quizz_question {
        if(empty($id)) return null;
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::QUESTION_BY_ID());
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return is_array($result) ? quizz_question::fromDB($result) : null;
    }

    /**
     * @return quizz_question[] | null
     */
    public static function findAll(): array {
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::QUESTIONS_ALL());
        $stmt->execute();
        $temp_res = $stmt->fetchAll();
        $result = [];
        foreach($temp_res as $res) {
            $result[] = quizz_question::fromDB($res);
        }
        return $result;
    }

    /**
     * @param string $where
     * @return quizz_question[] | null
     */
    public static function find(string $where): quizz_question {
        // TODO: Implement find() method.
    }

    /**
     * @param quizz_question $obj
     * @return bool
     */
    public static function update($obj): bool {
        // TODO: Implement update() method.
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool {
        // TODO: Implement delete() method.
    }

    /**
     * @param quizz_question $obj
     * @return quizz_question
     */
    public static function create($obj): quizz_question {
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::QUESTION_CREATE());
        if(empty($obj->question_title)) {
            $obj->question_title = "" . $obj->from_year;
            $obj->question_title.= $obj->from_summer ? " Sommer" : " Winter";
        }
        $summer = $obj->isFromSummerInt();
        $stmt->bindParam(":title", $obj->question_title );
        $stmt->bindParam(":question_text", $obj->question_text);
        $stmt->bindParam(":type", $obj->type);
        $stmt->bindParam(":area", $obj->area);
        $stmt->bindParam(":summer", $summer);
        $stmt->bindParam(":from_year", $obj->from_year);
        $stmt->bindParam(":moreinfo", $obj->moreinfo);
        $stmt->execute();

        $id = $db->lastInsertId();
        return quizz_question::findByID($id);
    }

    public static function randomQuestion($area = 1): quizz_question {
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::QUESTION_BY_RANDOM());
        $stmt->bindParam(":area", $area);
        $stmt->execute();
        $result = $stmt->fetch();
        return is_array($result) ? quizz_question::fromDB($result) : die("No question found!");
    }

}