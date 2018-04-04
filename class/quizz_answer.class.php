<?php
/**
 * Created: 28/03/2018 10:12
 */

class quizz_answer implements db_entry
{
    public const TABLE = "quizz_answers";

    /** @var int */
    private $id;
    /** @var int */
    private $question_id;
    /** @var string */
    private $text;
    /** @var bool */
    private $correct;
    /** @var bool */
    private $deleted;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getQuestionId(): int {
        return $this->question_id;
    }

    /**
     * @param int $question_id
     */
    public function setQuestionId(int $question_id): void {
        $this->question_id = $question_id;
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void {
        $this->text = $text;
    }

    /**
     * @return bool
     */
    public function isCorrect(): bool {
        return $this->correct;
    }

    /**
     * @param bool $correct
     */
    public function setCorrect(bool $correct): void {
        $this->correct = $correct;
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
     * @param int $id
     * @return quizz_answer | null
     */
    public static function findByID(int $id): quizz_answer {
        if(empty($id)) return null;
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::ANSWER_BY_ID());
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return is_array($result) ? quizz_answer::fromDB($result) : null;
    }

    /**
     * @param int $qid
     * @return quizz_answer[] | null
     */
    public static function findByQuestionID(int $qid): array {
        if(empty($qid)) return null;
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::ANSWERS_BY_QUESTION_ID());
        $stmt->bindParam(":qid", $qid);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if(!is_array($result)) return null;
        $anwers = [];
        foreach($result as $a) {
            $anwers[] = quizz_answer::fromDB($a);
        }
        return $anwers;
    }

    /**
     * @return quizz_answer[] | null
     */
    public static function findAll(): array {
        // TODO: Implement findAll() method.
    }

    /**
     * @param string $where
     * @return quizz_answer[] | null
     */
    public static function find(string $where): array {
        // TODO: Implement find() method.
    }

    /**
     * @param $obj
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
     * @param $obj quizz_answer
     * @return quizz_answer
     */
    public static function create($obj): quizz_answer {
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::ANSWER_CREATE());
        $correct = $obj->correct ? 1 : 0;
        $stmt->bindParam(":qid", $obj->question_id);
        $stmt->bindParam(":answer_text", $obj->text);
        $stmt->bindParam(":correct", $correct);
        $stmt->execute();
        $id = $db->lastInsertId();
        return quizz_answer::findByID($id);
    }

    /**
     * @param array $data
     * @return quizz_answer
     */
    public static function fromDB(array $data): quizz_answer {
        if(!is_array($data)) return null;
        $inst = new self();
        $inst->setId($data["ID"]);
        $inst->setQuestionId($data["qID"]);
        $inst->setText($data["answer_text"]);
        $inst->setCorrect($data["correct"]);
        return $inst;
    }


}