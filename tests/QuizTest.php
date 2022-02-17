<?php

use App\Question;
use App\Quiz;
use PHPUnit\Framework\TestCase;

class QuizTest extends TestCase
{
    /** @test */
    public function it_consists_of_questions()
    {
        $quiz = new Quiz;

        $quiz->addQuestion(
            new Question("What is 2+2?", 4)
        );

        $this->assertCount(1, $quiz->questions());
    }

    /** @test */
    public function it_grades_a_perfect_quiz()
    {
        $quiz = new Quiz;

        $quiz->addQuestion(new Question("What is 2+2?", 4));

        $question = $quiz->nextQuestion();

        $question->answer(4);

        $this->assertEquals(100, $quiz->grade());
    }

    /** @test */
    public function it_grades_a_failed_quiz()
    {
        $quiz = new Quiz;

        $quiz->addQuestion(new Question("What is 2+2?", 4));

        $question = $quiz->nextQuestion();

        $question->answer('incorrect answer');

        $this->assertEquals(0, $quiz->grade());
    }

    /** @test */
    public function it_correctly_tracks_the_next_question_in_the_queue()
    {
        $quiz = new Quiz;

        $quiz->addQuestion(new Question("What is 2+2?", 4));
        $quiz->addQuestion(new Question("What is the capital of El Salvador?", "San Salvador"));

        $quiz->nextQuestion();
        $question = $quiz->nextQuestion();

        $this->assertEquals("San Salvador", $question->solution());
    }

    /** @test */
    public function it_cannot_be_graded_until_all_questions_have_been_answered()
    {
        $quiz = new Quiz;

        $quiz->addQuestion(new Question("What is 2+2?", 4));
        $quiz->addQuestion(new Question("What is the capital of El Salvador?", "San Salvador"));

        $question = $quiz->nextQuestion();
        $question->answer(1);
        $question = $quiz->nextQuestion();
        $question->answer("San Salvador");

        $this->assertEquals(2, $quiz->isCompleted());
    }
}
