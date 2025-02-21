<?php

require_once __DIR__ . '/../core/ConsoleReport.php';
require_once __DIR__ . '/../core/DateTimeHandler.php';

class DiagnosticReport extends ConsoleReport {

   public function generate() {
      // Get data for recent assessment completed by student
      $studentResponse = $this->dataSource->getRecentlyCompletedStudentAssessment($this->student->id);
      if (empty($studentResponse)) {
         echo "Student has not completed any assessment!!\n\n";
         exit;
      }

      // Get data for assessment completd by student
      $assessment = $this->dataSource->getAssessmentById($studentResponse->assessmentId);

      // Print report
      echo strtr("{student_full_name} recently completed {assessment_title} assessment on {date_completed}\nHe got {total_correct} questions right out of {total}. Details by strand given below:\n\n{strand_details}", [
         '{student_full_name}' => $this->student->getFullName(),
         '{assessment_title}' => $assessment->name,
         '{date_completed}' => DateTimeHandler::convertDate($studentResponse->completed, 'long'),
         '{total_correct}' => $studentResponse->results['rawScore'],
         '{total}' => count($studentResponse->responses),
         '{strand_details}' => $studentResponse->getStrandDetailsStr()
      ]);
   }
}
