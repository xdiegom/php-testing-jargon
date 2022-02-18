<?php

namespace Tests;

use App\Question;
use App\Quiz;
use PHPUnit\Framework\TestCase;

class QuizTest extends TestCase
{
    /**
     * @test
     */
    public function itConsistsOfQuestions()
    {
        $quiz = new Quiz();

        $quiz->addQuestion(
            new Question("What is 2+2?", 4)
        );

        $this->assertCount(1, $quiz->questions());
    }

    /**
     * @test
     */
    public function itGradesAPerfectQuiz()
    {
        $quiz = new Quiz();

        $quiz->addQuestion(new Question("What is 2+2?", 4));

        $question = $quiz->nextQuestion();

        $question->answer(4);

        $this->assertEquals(100, $quiz->grade());
    }

    /**
     * @test
     */
    public function itGradesAFailedQuiz()
    {
        $quiz = new Quiz();

        $quiz->addQuestion(new Question("What is 2+2?", 4));

        $question = $quiz->nextQuestion();

        $question->answer('incorrect answer');

        $this->assertEquals(0, $quiz->grade());
    }

    /**
     * @test
     */
    public function itCorrectlyTracksTheNextQuestionInTheQueue()
    {
        $quiz = new Quiz();

        $quiz->addQuestion(new Question("What is 2+2?", 4));
        $quiz->addQuestion(new Question("What is the capital of El Salvador?", "San Salvador"));

        $quiz->nextQuestion();
        $question = $quiz->nextQuestion();

        $this->assertEquals("San Salvador", $question->solution());
    }

    /**
     * @test
     */
    public function itCannotBeGradedUntilAllQuestionsHaveBeenAnswered()
    {
        $quiz = new Quiz();

        $quiz->addQuestion(new Question("What is 2+2?", 4));

        $this->expectException(\Exception::class);

        $quiz->grade();
    }
}
