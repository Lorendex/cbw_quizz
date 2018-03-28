<?php
/**
 * Created: 28/03/2018 10:12
 */

class quizz_question
{
    /** @var int */
    private $id;

    /** @var string */
    private $question_title;

    /** @var quizz_answer[] */
    private $answers = [];

    /** @var quizz_question_type */
    private $type;

    /** @var quizz_question_area */
    private $area;

    /** quizz_question constructor */
    public function __construct() {
    }
    /** @return int */
    public function getId(): int {
        return $this->id;
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

    /** @return quizz_question_type */
    public function getType(): quizz_question_type {
        return $this->type;
    }

    /** @param quizz_question_type $type */
    public function setType(quizz_question_type $type): void {
        $this->type = $type;
    }

    /** @return quizz_question_area */
    public function getArea(): quizz_question_area {
        return $this->area;
    }

    /** @param quizz_question_area $area */
    public function setArea(quizz_question_area $area): void {
        $this->area = $area;
    }

}