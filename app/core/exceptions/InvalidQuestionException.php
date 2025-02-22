<?php

class InvalidQuestionException extends Exception {

   public function __construct($message = "Invalid question data", $code = 400) {
      parent::__construct($message, $code);
   }
}
