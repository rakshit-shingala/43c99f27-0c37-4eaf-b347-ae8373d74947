<?php

require_once __DIR__ . '/../core/ConsoleReport.php';
require_once __DIR__ . '/../core/DateTimeHandler.php';

class ProgressReport extends ConsoleReport {

   public function generate() {
      // Get all assessments completed by student
      $studentResponses = $this->dataSource->getCompletedStudentAssessments($this->student->id);
      if (empty($studentResponses)) {
         echo "Student has not completed any assessment!!\n\n";
         exit;
      }

      // Get data for assessment completd by student
      $assessment = $this->dataSource->getAssessmentById($studentResponses[0]['assessmentId']);

      // Print report
      echo strtr("{student_full_name} has completed {assessment_title} assessment {total_completed} times in total. Date and raw score given below:\n\n", [
         '{student_full_name}' => $this->student->getFullName(),
         '{assessment_title}' => $assessment->getName(),
         '{total_completed}' => count($studentResponses)
      ]);

      // Show progress summary of each assessment taken
      foreach ($studentResponses as $studentResponse) {
         echo strtr("Date: {date_completed}, Raw Score: {total_correct} out of {total}\n", [
            '{date_completed}' => DateTimeHandler::convertDate($studentResponse['completed'], 'short'),
            '{total_correct}' => $studentResponse['results']['rawScore'],
            '{total}' => count($studentResponse['responses'])
         ]);
      }

      // Compare and show progress summary of most recent assessment taken with oldest
      if (count($studentResponses) > 1) {
         $this->summariseProgress();
      }
   }

   public function summariseProgress() {
      // Get data for recent assessment completed by student
      $studentResponseNewest = $this->dataSource->getRecentlyCompletedStudentAssessment($this->student->id);
      $newRawScore = $studentResponseNewest->results['rawScore'];

      // Get data for oldest assessment completed by student
      $studentResponseOldest = $this->dataSource->getOldestCompletedStudentAssessment($this->student->id);
      $oldRawScore = $studentResponseOldest->results['rawScore'];

      echo strtr("\n{student_full_name} got {total} more {compare_result} in the recent completed assessment than the oldest.\n", [
         '{student_full_name}' => $this->student->getFullName(),
         '{total}' => $newRawScore > $oldRawScore ? $newRawScore - $oldRawScore : $oldRawScore - $newRawScore,
         '{compare_result}' => $newRawScore > $oldRawScore ? 'correct' : 'incorrect'
      ]);
   }
}
