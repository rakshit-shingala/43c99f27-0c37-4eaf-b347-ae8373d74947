<?php

require_once __DIR__ . '/../core/Command.php';

class ReportCommand extends Command {
   public function execute($args) {
      echo "Please enter the following\n";

      // Ask the user to enter student id
      echo "Student ID: ";
      $studentID = trim(fgets(STDIN)); // Read input from user

      // Ask the user to select report which should be generated
      echo "Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback): ";
      $report = trim(fgets(STDIN)); // Read input from user
   }
}