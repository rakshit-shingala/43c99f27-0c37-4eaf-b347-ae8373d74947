<?php

require_once __DIR__ . '/../core/Command.php';
require_once __DIR__ . '/../components/DiagnosticReport.php';
require_once __DIR__ . '/../components/ProgressReport.php';
require_once __DIR__ . '/../components/FeedbackReport.php';

class ReportCommand extends Command {

   protected $reports = [
      "report1" => "DiagnosticReport",
      "report2" => "ProgressReport",
      "report3" => "FeedbackReport"
   ];

   public function execute($args) {
      echo "Please enter the following\n";

      // Ask the user to enter student id
      echo "Student ID: ";
      $studentID = trim(fgets(STDIN)); // Read input from user

      do {
         // Ask the user to select report which should be generated
         echo "Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback): ";
         $reportID = trim(fgets(STDIN)); // Read input from user

         $isValidReport = isset($this->reports["report$reportID"]);
         if (!$isValidReport) {
            echo "Invalid input, try again!\n";
         }
      } while (!$isValidReport);
      echo "\n";

      // Generate chosen report
      $report = new $this->reports["report$reportID"]($studentID);
      $report->generate();
   }
}
