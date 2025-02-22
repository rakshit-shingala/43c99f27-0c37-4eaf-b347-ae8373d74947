<?php

require_once __DIR__ . '/../commands/Command.php';
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
      try {
         echo "Please enter the following\n";
         $studentID = $this->promptUserToEnterStudentID();
         $reportID = $this->promptUserToEnterReportID();
         echo "\n";

         // Generate chosen report
         $report = new $this->reports["report$reportID"]($studentID);
         $report->generate();
      } catch (InvalidStudentException $e) {
         echo "Student Data Error: " . $e->getMessage() . PHP_EOL;
      } catch (InvalidAssessmentException $e) {
         echo "Assessment Data Error: " . $e->getMessage() . PHP_EOL;
      } catch (InvalidQuestionException $e) {
         echo "Question Data Error: " . $e->getMessage() . PHP_EOL;
      } catch (InvalidStudentResponseException $e) {
         echo "Student Response Data Error: " . $e->getMessage() . PHP_EOL;
      } catch (Exception $e) {
         echo "Unexpected Error: " . $e->getMessage() . PHP_EOL;
      }
   }

   public function promptUserToEnterReportID() {
      do {
         // Ask the user to select report which should be generated
         echo "Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback): ";
         $reportID = trim(fgets(STDIN)); // Read input from user

         $isValidReport = isset($this->reports["report$reportID"]);
         if (!$isValidReport) {
            echo "Invalid input, try again!\n";
         }
      } while (!$isValidReport);

      return $reportID;
   }
}
