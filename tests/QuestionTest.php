<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Question.php';

class QuestionTest extends TestCase {

   private ?Question $question;
   private array $questionData = [
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
   ];

   public function testCorrectAnswerReturnsCorrectFormat() {
      $this->assertEquals($this->questionData['config']['key'], $this->question->getCorrectAnswer());
   }

   public function testStemReturnsCorrectFormat() {
      $this->assertEquals($this->questionData['stem'], $this->question->getStem());
   }

   public function testHintReturnsCorrectFormat() {
      $this->assertEquals($this->questionData['config']['hint'], $this->question->getHint());
   }

   public function testStrandReturnsCorrectFormat() {
      $this->assertEquals($this->questionData['strand'], $this->question->getStrand());
   }

   public function testOptionsReturnsCorrectFormat() {
      $this->assertArrayIsEqualToArrayIgnoringListOfKeys($this->questionData['config']['options'], $this->question->getOptions(), []);
   }

   public function testOptionReturnsCorrectFormat() {
      $this->assertArrayIsEqualToArrayIgnoringListOfKeys($this->questionData['config']['options'][0], $this->question->getOption('option1'), []);
      $this->assertArrayIsEqualToArrayIgnoringListOfKeys($this->questionData['config']['options'][1], $this->question->getOption('option2'), []);
      $this->assertArrayIsEqualToArrayIgnoringListOfKeys($this->questionData['config']['options'][2], $this->question->getOption('option3'), []);
      $this->assertArrayIsEqualToArrayIgnoringListOfKeys($this->questionData['config']['options'][3], $this->question->getOption('option4'), []);
   }

   public function testCorrectAnswerOptionReturnsCorrectFormat() {
      $this->assertArrayIsEqualToArrayIgnoringListOfKeys($this->questionData['config']['options'][2], $this->question->getCorrectAnswerOption(), []);
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

   public function testMandatoryID() {
      $this->expectException(InvalidQuestionException::class);
      $testData = $this->questionData;
      unset($testData['id']);
      new Question($testData);
   }

   public function testMandatoryStem() {
      $this->expectException(InvalidQuestionException::class);
      $testData = $this->questionData;
      unset($testData['stem']);
      new Question($testData);
   }

   public function testMandatoryStrand() {
      $this->expectException(InvalidQuestionException::class);
      $testData = $this->questionData;
      unset($testData['strand']);
      new Question($testData);
   }

   public function testMandatoryConfig() {
      $this->expectException(InvalidQuestionException::class);
      $testData = $this->questionData;
      unset($testData['config']);
      new Question($testData);
   }

   public function testMandatoryAnswerKey() {
      $this->expectException(InvalidQuestionException::class);
      $testData = $this->questionData;
      unset($testData['config']['key']);
      new Question($testData);
   }

   public function testMandatoryHint() {
      $this->expectException(InvalidQuestionException::class);
      $testData = $this->questionData;
      unset($testData['config']['hint']);
      new Question($testData);
   }

   public function testMandatoryOptions() {
      $this->expectException(InvalidQuestionException::class);
      $testData = $this->questionData;
      unset($testData['config']['options']);
      new Question($testData);
   }

   protected function setUp(): void {
      $this->question = new Question($this->questionData);
   }

   protected function tearDown(): void {
      $this->question = null;
   }
}
