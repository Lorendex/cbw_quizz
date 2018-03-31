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
     * @param int $id
     * @return quizz_answer | null
     */
    public static function findByID(int $id): quizz_answer {
        // TODO: Implement findByID() method.
    }

    /**
     * @param int $qid
     * @return quizz_answer[] | null
     */
    public static function findByQuestionID(int $qid): array {
        if(empty($id)) return null;
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::QUESTION_BY_ID());
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return is_array($result) ? new quizz_question($result) : null;
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
     * @param $obj
     * @return quizz_answer
     */
    public static function create($obj): quizz_answer {
        // TODO: Implement create() method.
    }

    /**
     * @param array $data
     * @return quizz_answer
     */
    public static function fromDB(array $data): quizz_answer {
        // TODO: Implement fromDB() method.
    }


}