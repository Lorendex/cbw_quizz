<?php
/**
 * Created: 28/03/2018 10:12
 */

class quizz_answer
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
}