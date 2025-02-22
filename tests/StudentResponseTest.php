<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/StudentResponse.php';

class StudentResponseTest extends TestCase {

   private ?StudentResponse $studentResponse;
   private array $studentResponseData = [
      "id" => "studentReponse3",
      "assessmentId" => "assessment1",
      "assigned" => "14/12/2021 10:31:00",
      "started" => "16/12/2021 10:00:00",
      "completed" => "16/12/2021 10:46:00",
      "student" => [
         "id" => "student1",
         "yearLevel" => 5
      ],
      "responses" => [
         [
            "questionId" => "numeracy1",
            "response" => "option3"
         ],
         [
            "questionId" => "numeracy2",
            "response" => "option4"
         ],
         [
            "questionId" => "numeracy3",
            "response" => "option2"
         ],
         [
            "questionId" => "numeracy4",
            "response" => "option2"
         ],
         [
            "questionId" => "numeracy5",
            "response" => "option3"
         ],
         [
            "questionId" => "numeracy6",
            "response" => "option3"
         ],
         [
            "questionId" => "numeracy7",
            "response" => "option4"
         ],
         [
            "questionId" => "numeracy8",
            "response" => "option4"
         ],
         [
            "questionId" => "numeracy9",
            "response" => "option2"
         ],
         [
            "questionId" => "numeracy10",
            "response" => "option2"
         ],
         [
            "questionId" => "numeracy11",
            "response" => "option2"
         ],
         [
            "questionId" => "numeracy12",
            "response" => "option2"
         ],
         [
            "questionId" => "numeracy13",
            "response" => "option3"
         ],
         [
            "questionId" => "numeracy14",
            "response" => "option1"
         ],
         [
            "questionId" => "numeracy15",
            "response" => "option2"
         ],
         [
            "questionId" => "numeracy16",
            "response" => "option1"
         ]
      ],
      "results" => [
         "rawScore" => 15
      ]
   ];

   public function testMandatoryID() {
      $this->expectException(InvalidStudentResponseException::class);
      $testData = $this->studentResponseData;
      unset($testData['id']);
      new StudentResponse($testData);
   }

   public function testMandatoryAssessmentID() {
      $this->expectException(InvalidStudentResponseException::class);
      $testData = $this->studentResponseData;
      unset($testData['assessmentId']);
      new StudentResponse($testData);
   }

   public function testMandatoryStudent() {
      $this->expectException(InvalidStudentResponseException::class);
      $testData = $this->studentResponseData;
      unset($testData['student']);
      new StudentResponse($testData);
   }

   public function testMandatoryStudentID() {
      $this->expectException(InvalidStudentResponseException::class);
      $testData = $this->studentResponseData;
      unset($testData['student']['id']);
      new StudentResponse($testData);
   }

   public function testMandatoryResponses() {
      $this->expectException(InvalidStudentResponseException::class);
      $testData = $this->studentResponseData;
      unset($testData['responses']);
      new StudentResponse($testData);
   }

   public function testMandatoryResults() {
      $this->expectException(InvalidStudentResponseException::class);
      $testData = $this->studentResponseData;
      unset($testData['results']);
      new StudentResponse($testData);
   }

   public function testMandatoryRawScore() {
      $this->expectException(InvalidStudentResponseException::class);
      $testData = $this->studentResponseData;
      unset($testData['results']['rawScore']);
      new StudentResponse($testData);
   }

   protected function setUp(): void {
      $this->studentResponse = new StudentResponse($this->studentResponseData);
   }

   protected function tearDown(): void {
      $this->studentResponse = null;
   }
}
