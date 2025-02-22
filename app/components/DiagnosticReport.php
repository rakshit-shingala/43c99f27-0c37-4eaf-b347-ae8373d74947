<?php

require_once __DIR__ . '/ConsoleReport.php';
require_once __DIR__ . '/DateTimeHandler.php';

class DiagnosticReport extends ConsoleReport {

   public function generate() {
      // Get data for recent assessment completed by student
      $studentResponse = $this->dataSource->getRecentlyCompletedStudentAssessment($this->student->id);
      if (empty($studentResponse)) {
         throw new InvalidStudentResponseException("0 assessment completed.");
      }

      // Get data for assessment completd by student
      $assessment = $this->dataSource->getAssessmentById($studentResponse->assessmentId);
      if (empty($assessment)) {
         throw new InvalidAssessmentException("Record with ID \"$studentResponse->assessmentId\" not found.");
      }

      // Print report
      echo strtr("{student_full_name} recently completed {assessment_title} assessment on {date_completed}\n"
            . "He got {total_correct} questions right out of {total}. Details by strand given below:\n\n"
            . "{strand_details}", [
         '{student_full_name}' => $this->student->getFullName(),
         '{assessment_title}' => $assessment->getName(),
         '{date_completed}' => DateTimeHandler::convertDate($studentResponse->completed, 'long'),
         '{total_correct}' => $studentResponse->results['rawScore'],
         '{total}' => count($studentResponse->responses),
         '{strand_details}' => $studentResponse->getStrandDetailsStr()
      ]);
   }
}
