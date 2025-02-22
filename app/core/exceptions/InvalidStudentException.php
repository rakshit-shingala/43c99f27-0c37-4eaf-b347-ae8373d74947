<?php

class InvalidStudentException extends Exception {

   public function __construct($message = "Invalid student data", $code = 400) {
      parent::__construct($message, $code);
   }
}
