<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Question.php';

class QuestionTest extends TestCase {

   private ?Question $question;

   public function testCorrectAnswerReturnsCorrectFormat() {
      $this->assertEquals("option3", $this->question->getCorrectAnswer());
   }

   public function testStemReturnsCorrectFormat() {
      $this->assertEquals("What is the value of 2 + 3 x 5?", $this->question->getStem());
   }

   public function testHintReturnsCorrectFormat() {
      $this->assertEquals("Work out the multiplication sign BEFORE the addition sign", $this->question->getHint());
   }

   public function testStrandReturnsCorrectFormat() {
      $this->assertEquals("Number and Algebra", $this->question->getStrand());
   }

   public function testOptionsReturnsCorrectFormat() {
      $this->assertArrayIsEqualToArrayIgnoringListOfKeys([
         ['id' => 'option1', 'label' => 'A', 'value' => '10'],
         ['id' => 'option2', 'label' => 'B', 'value' => '15'],
         ['id' => 'option3', 'label' => 'C', 'value' => '17'],
         ['id' => 'option4', 'label' => 'D', 'value' => '25'],
      ], $this->question->getOptions(), []);
   }

   public function testOptionReturnsCorrectFormat() {
      $this->assertArrayIsEqualToArrayIgnoringListOfKeys(['id' => 'option1', 'label' => 'A', 'value' => '10'], $this->question->getOption('option1'), []);
   }

   public function testCorrectAnswerOptionReturnsCorrectFormat() {
      $this->assertArrayIsEqualToArrayIgnoringListOfKeys(['id' => 'option3', 'label' => 'C', 'value' => '17'], $this->question->getCorrectAnswerOption(), []);
   }

   public function testCorrectAnswerCheckRunCorrect() {
      $this->assertFalse($this->question->isAnsweredCorrectly('option1'));
      $this->assertFalse($this->question->isAnsweredCorrectly('option2'));
      $this->assertTrue($this->question->isAnsweredCorrectly('option3'));
      $this->assertFalse($this->question->isAnsweredCorrectly('option4'));
   }

   public function testFeedbackForWrongAnswerReturnsCorrectFormat() {
      $this->assertEquals("Question: What is the value of 2 + 3 x 5?\n"
            . "Your Answer: A with value 10\n"
            . "Right Answer: C with value 17\n"
            . "Hint: Work out the multiplication sign BEFORE the addition sign\n", $this->question->getFeedbackForWrongAnswer('option1'));

      $this->assertEquals("Question: What is the value of 2 + 3 x 5?\n"
            . "Your Answer: B with value 15\n"
            . "Right Answer: C with value 17\n"
            . "Hint: Work out the multiplication sign BEFORE the addition sign\n", $this->question->getFeedbackForWrongAnswer('option2'));

      $this->assertEquals(null, $this->question->getFeedbackForWrongAnswer('option3'));

      $this->assertEquals("Question: What is the value of 2 + 3 x 5?\n"
            . "Your Answer: D with value 25\n"
            . "Right Answer: C with value 17\n"
            . "Hint: Work out the multiplication sign BEFORE the addition sign\n", $this->question->getFeedbackForWrongAnswer('option4'));
   }

   protected function setUp(): void {
      $this->question = new Question([
         'id' => 'numeracy1',
         'stem' => 'What is the value of 2 + 3 x 5?',
         'type' => 'multiple-choice',
         'strand' => "Number and Algebra",
         'config' => [
            'options' => [
               ['id' => 'option1', 'label' => 'A', 'value' => '10'],
               ['id' => 'option2', 'label' => 'B', 'value' => '15'],
               ['id' => 'option3', 'label' => 'C', 'value' => '17'],
               ['id' => 'option4', 'label' => 'D', 'value' => '25'],
            ],
            'key' => 'option3',
            'hint' => 'Work out the multiplication sign BEFORE the addition sign'
         ]
      ]);
   }

   protected function tearDown(): void {
      $this->question = null;
   }
}
