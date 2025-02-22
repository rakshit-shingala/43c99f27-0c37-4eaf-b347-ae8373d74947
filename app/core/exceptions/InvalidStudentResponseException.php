<?php

class InvalidStudentResponseException extends Exception {

   public function __construct($message = "Invalid student response data", $code = 400) {
      parent::__construct($message, $code);
   }
}
