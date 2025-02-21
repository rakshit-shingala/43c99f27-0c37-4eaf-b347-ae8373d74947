<?php

require_once __DIR__ . '/../core/ConsoleApplication.php';
require_once __DIR__ . '/../models/AppModel.php';

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
      $this->id = $data['id'] ?? null;
      $this->assessmentId = $data['assessmentId'] ?? null;
      $this->assigned = $data['assigned'] ?? null;
      $this->started = $data['started'] ?? null;
      $this->completed = $data['completed'] ?? null;
      $this->student = $data['student'] ?? null;
      $this->responses = $data['responses'] ?? null;
      $this->results = $data['results'] ?? null;
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
            echo "Student has response for question which does not exist.\n";
            exit;
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
            echo "Student has response for question which does not exist.\n";
            exit;
         }

         $question = $questions[$questionId];
         $answerId = $questionResponse['response'];
         if (!$question->isAnsweredCorrectly($answerId)) {
            $feedback .= $question->getFeedbackForWrongAnswer($answerId) . "\n";
         }
      }

      return $feedback;
   }
}
