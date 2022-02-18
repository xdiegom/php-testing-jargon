<?php

namespace App;

class Quiz
{
    protected array $questions;
    protected int $currentQuestion;

    public function __construct()
    {
        $this->currentQuestion = -1;
    }

    public function addQuestion(Question $question)
    {
        $this->questions[] = $question;
    }

    public function questions()
    {
        return $this->questions;
    }

    public function nextQuestion(): ?Question
    {
        $this->currentQuestion += 1;

        return array_key_exists($this->currentQuestion, $this->questions) ?
            $this->questions[$this->currentQuestion] :
            null;
    }

    public function grade()
    {
        if (! $this->isCompleted()) {
            throw new \Exception("Quiz is not completed");
        }

        $correct = count($this->correctlyAnswerdQuestions());

        return ($correct / count($this->questions)) * 100;
    }

    public function isCompleted()
    {
        return $this->answeredQuestions() === count($this->questions);
    }

    protected function correctlyAnswerdQuestions()
    {
        return array_filter(
            $this->questions,
            fn ($question) => $question->isCorrect()
        );
    }

    protected function answeredQuestions()
    {
        return count(
            array_filter(
                $this->questions,
                fn ($question) => $question->answered()
            )
        );
    }
}
