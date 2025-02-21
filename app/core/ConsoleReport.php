<?php

require_once __DIR__ . '/../core/ConsoleApplication.php';
require_once __DIR__ . '/../core/JSONDataSource.php';

abstract class ConsoleReport {

   protected $student;
   protected $dataSource;

   public function __construct(string $studentID) {
      $app = ConsoleApplication::getInstance();

      // Initialise data source which will be used to fetch data
      $this->dataSource = $app->getDataSource();

      // Get data for student
      $this->student = $this->dataSource->getStudentById($studentID);
      if (empty($this->student)) {
         echo "Student not found matching provided id!\n\n";
         exit;
      }
   }

   abstract public function generate();
}
