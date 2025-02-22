<?php

require_once __DIR__ . '/../core/ConsoleApplication.php';
require_once __DIR__ . '/../models/AppModel.php';
require_once __DIR__ . '/../core/exceptions/InvalidStudentResponseException.php';

class StudentResponse extends AppModel {

   // Properties of the student response model
   public string $id;
   public string $assessmentId;
   public string $assigned;
   public string $started;
   public string $completed;
   public array $student;
   public array $responses;
   public array $results;

   public function loadData(array $data) {
      $this->validate($data);
      $this->id = $data['id'];
      $this->assessmentId = $data['assessmentId'];
      $this->assigned = $data['assigned'] ?? '';
      $this->started = $data['started'] ?? '';
      $this->completed = $data['completed'] ?? '';
      $this->student = $data['student'];
      $this->responses = $data['responses'];
      $this->results = $data['results'];
   }

   public function validate($data) {
      if (empty($data['id'])) {
         throw new InvalidStudentResponseException("ID is required.");
      }
      if (empty($data['assessmentId'])) {
         throw new InvalidStudentResponseException("Assessment ID is required.");
      }
      if (!empty($data['completed'])) {
         $app = ConsoleApplication::getInstance();
         $format = $app->getParam("saved_date_format");
         if (!DateTime::createFromFormat($format, $data['completed'])) {
            throw new InvalidStudentResponseException("Completed date foramt is in an incorrect format.");
         }
      }
      if (empty($data['student']) || empty($data['student']['id'])) {
         throw new InvalidStudentResponseException("Student is required.");
      }
      if (empty($data['responses'])) {
         throw new InvalidStudentResponseException("Responses are required.");
      }
      if (empty($data['results'])) {
         throw new InvalidStudentResponseException("Results are required.");
      }
      if (!isset($data['results']['rawScore']) || is_null($data['results']['rawScore'])) {
         throw new InvalidStudentResponseException("Raw score is required.");
      }
   }

   public function getStrandDetails() {
      $app = ConsoleApplication::getInstance();

      // Get data for all questions
      $questions = $app->getDataSource()->getQuestions();

      // Generate strand detail
      $strands = [];
      foreach ($this->responses as $questionResponse) {
         $questionId = $questionResponse['questionId'];
         if (!isset($questions[$questionId])) {
            throw new InvalidStudentResponseException("Student has response for question which does not exist.\n");
         }

         $question = $questions[$questionId];
         $strand = $question->getStrand();

         // intialise data for new strand
         if (!isset($strands[$strand])) {
            $strands[$strand] = ["correct" => 0, "total" => 0];
         }

         $strands[$strand]['total']++;
         if ($question->isAnsweredCorrectly($questionResponse['response'])) {
            $strands[$strand]['correct']++;
         }
      }

      return $strands;
   }

   public function getStrandDetailsStr() {
      // Get strand details
      $strandResults = $this->getStrandDetails();

      $strandResultsStr = "";
      foreach ($strandResults as $strandTitle => $strandResult) {
         $strandResultsStr .= strtr("{strand_title}: {correct} out of {total} correct\n", [
            '{strand_title}' => $strandTitle,
            '{correct}' => $strandResult['correct'],
            '{total}' => $strandResult['total']
         ]);
      }

      return $strandResultsStr;
   }

   public function getFeedbackForWrongAnswers() {
      $app = ConsoleApplication::getInstance();

      // Get data for all questions
      $questions = $app->getDataSource()->getQuestions();

      // Fing wrong answers
      $feedback = "";
      foreach ($this->responses as $questionResponse) {
         $questionId = $questionResponse['questionId'];
         if (!isset($questions[$questionId])) {
            throw new InvalidStudentResponseException("Student has response for question which does not exist.\n");
         }

         $question = $questions[$questionId];
         $answerFeedback = $question->getFeedbackForWrongAnswer($questionResponse['response']);
         if ($answerFeedback) {
            $feedback .= $answerFeedback . "\n";
         }
      }

      return $feedback;
   }
}
