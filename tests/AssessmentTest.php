<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Assessment.php';
require_once __DIR__ . '/../app/core/exceptions/InvalidAssessmentException.php';

class AssessmentTest extends TestCase {

   private ?Assessment $assessment;
   private array $assessmentData = [
      "id" => "assessment1",
      "name" => "Numeracy",
      "questions" => [
         [
            "questionId" => "numeracy1",
            "position" => 1
         ],
         [
            "questionId" => "numeracy2",
            "position" => 2
         ],
         [
            "questionId" => "numeracy3",
            "position" => 3
         ],
         [
            "questionId" => "numeracy4",
            "position" => 4
         ],
         [
            "questionId" => "numeracy5",
            "position" => 5
         ],
         [
            "questionId" => "numeracy6",
            "position" => 6
         ],
         [
            "questionId" => "numeracy7",
            "position" => 7
         ],
         [
            "questionId" => "numeracy8",
            "position" => 8
         ],
         [
            "questionId" => "numeracy9",
            "position" => 9
         ],
         [
            "questionId" => "numeracy10",
            "position" => 10
         ],
         [
            "questionId" => "numeracy11",
            "position" => 11
         ],
         [
            "questionId" => "numeracy12",
            "position" => 12
         ],
         [
            "questionId" => "numeracy13",
            "position" => 13
         ],
         [
            "questionId" => "numeracy14",
            "position" => 14
         ],
         [
            "questionId" => "numeracy15",
            "position" => 15
         ],
         [
            "questionId" => "numeracy16",
            "position" => 16
         ]
      ]
   ];

   public function testFullNameReturnsCorrectFormat() {
      $this->assertEquals("Numeracy", $this->assessment->getName());
   }

   public function testMandatoryID() {
      $this->expectException(InvalidAssessmentException::class);
      $testData = $this->assessmentData;
      unset($testData['id']);
      new Assessment($testData);
   }

   public function testMandatoryName() {
      $this->expectException(InvalidAssessmentException::class);
      $testData = $this->assessmentData;
      unset($testData['name']);
      new Assessment($testData);
   }

   protected function setUp(): void {
      $this->assessment = new Assessment($this->assessmentData);
   }

   protected function tearDown(): void {
      $this->assessment = null;
   }
}
