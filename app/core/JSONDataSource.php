<?php

require_once __DIR__ . '/../core/DataSource.php';
require_once __DIR__ . '/../components/DateTimeHandler.php';
require_once __DIR__ . '/../components/JSONFileHandler.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Assessment.php';
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/StudentResponse.php';

class JSONDataSource extends DataSource {

   protected $location;

   public function __construct(array $location) {
      $this->location = $location;
   }

   /**
    * Retrieve data matching student id from the JSON file storing all students data.
    * 
    * @param string $studentID Primary key of student
    * @return null|\Student
    */
   public function getStudentById(string $studentID) {
      $fileHandler = new JSONFileHandler($this->location['students'], "id");
      $studentData = $fileHandler->readOne($studentID);

      if (empty($studentData)) {
         return null;
      }

      return new Student($studentData);
   }

   /**
    * Retrieve all student responses stored within JSON file.
    * 
    * @return array
    */
   public function getStudentResponses() {
      $fileHandler = new JSONFileHandler($this->location['student_responses'], "id");

      return $fileHandler->readAll();
   }

   /**
    * Retrieve student responses only for most recently completed assessment
    * within JSON file which matches student id.
    * 
    * @param string $studentID Primary key of student
    * @return @return null|\StudentResponse
    */
   public function getRecentlyCompletedStudentAssessment(string $studentID) {
      $data = null;
      $app = ConsoleApplication::getInstance();
      $format = $app->getParam("saved_date_format");

      $studentResponses = $this->getStudentResponses();
      foreach ($studentResponses as $studentResponse) {
         $studentResponseModel = new StudentResponse($studentResponse);

         // Analyzing completed assessments only which matches provided student
         if (!isset($studentResponse['completed']) || $studentResponse['student']['id'] !== $studentID) {
            continue;
         }

         // Select first assessment if found
         if (empty($data) || DateTimeHandler::isRecent($data->completed, $studentResponseModel->completed, $format)) {
            $data = $studentResponseModel;
         }
      }

      return $data;
   }

   /**
    * Retrieve student responses only for most oldest completed assessment
    * within JSON file which matches student id.
    * 
    * @param string $studentID Primary key of student
    * @return @return null|\StudentResponse
    */
   public function getOldestCompletedStudentAssessment(string $studentID) {
      $data = null;
      $app = ConsoleApplication::getInstance();
      $format = $app->getParam("saved_date_format");

      $studentResponses = $this->getStudentResponses();
      foreach ($studentResponses as $studentResponse) {
         $studentResponseModel = new StudentResponse($studentResponse);

         // Analyzing completed assessments only which matches provided student
         if (!isset($studentResponse['completed']) || $studentResponse['student']['id'] !== $studentID) {
            continue;
         }

         // Select first assessment if found
         if (empty($data) || DateTimeHandler::isOlder($data->completed, $studentResponseModel->completed, $format)) {
            $data = $studentResponseModel;
         }
      }

      return $data;
   }

   /**
    * Retrieve all student responses for completed assessments within JSON file
    * which matches student id.
    * 
    * @param string $studentID Primary key of student
    * @return array
    */
   public function getCompletedStudentAssessments(string $studentID) {
      $data = [];

      $studentResponses = $this->getStudentResponses();
      foreach ($studentResponses as $studentResponse) {
         // Analyzing completed assessments only which matches provided student
         if (!isset($studentResponse['completed']) || $studentResponse['student']['id'] !== $studentID) {
            continue;
         }

         $data[] = new StudentResponse($studentResponse);
      }

      return $data;
   }

   /**
    * Retrieve data matching assessment id from the JSON file storing all assessments data.
    * 
    * @param string $assessmentID Primary key of assessment
    * @return null|\Assessment
    */
   public function getAssessmentById(string $assessmentID) {
      $fileHandler = new JSONFileHandler($this->location['assessments'], "id");
      $assessmentData = $fileHandler->readOne($assessmentID);

      if (empty($assessmentData)) {
         return null;
      }

      return new Assessment($assessmentData);
   }

   /**
    * Retrieve all questions stored within JSON file.
    * 
    * @return array
    */
   public function getQuestions() {
      $fileHandler = new JSONFileHandler($this->location['questions'], "id");

      $fileData = $fileHandler->readAll();
      $questions = [];
      foreach ($fileData as $data) {
         $questions[$data['id']] = new Question($data);
      }

      return $questions;
   }
}
