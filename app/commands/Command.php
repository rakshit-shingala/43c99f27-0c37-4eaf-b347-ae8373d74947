<?php

abstract class Command {

   abstract public function execute($args);

   public function promptUserToEnterStudentID() {
      // Ask the user to enter student id
      echo "Student ID: ";
      return trim(fgets(STDIN)); // Read input from user
   }
}
