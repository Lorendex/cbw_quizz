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

    /** quizz_question constructor */
    public function __construct() {
    }


    /** @param int $id */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /** @return string */
    public function getQuestionTitle(): string {
        return $this->question_title;
    }

    /** @param string $question_title */
    public function setQuestionTitle(string $question_title): void {
        $this->question_title = $question_title;
    }

    /** @return quizz_answer[] */
    public function getAnswers(): array {
        return $this->answers;
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
     * @param array $data
     * @return quizz_question
     */
    public static function fromDB(array $data): quizz_question{
        if(!is_array($data)) return null;
        $inst = new self();
        $inst->setId($data["id"]);
        $inst->setArea($data["area"]);
        $inst->setType($data["type"]);
        $inst->setQuestionTitle($data["title"]);
        $inst->setQuestionText($data["question"]);
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
        return is_array($result) ? new quizz_question($result) : null;
    }

    /**
     * @return quizz_question[] | null
     */
    public static function findAll(): array {
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::QUESTIONS_ALL());
        $stmt->execute();
        $result = $stmt->fetchAll();
        return is_array($result) ? new quizz_question($result) : null;
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
        // TODO: Implement create() method.
    }


}