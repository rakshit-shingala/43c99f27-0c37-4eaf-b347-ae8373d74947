<?php

class InvalidAssessmentException extends Exception {

   public function __construct($message = "Invalid assessment data", $code = 400) {
      parent::__construct($message, $code);
   }
}
