<?php

require_once __DIR__ . '/../models/AppModel.php';
require_once __DIR__ . '/../core/exceptions/InvalidAssessmentException.php';

class Assessment extends AppModel {

   // Properties of the assessment model
   public string $id;
   public string $name;
   public array $questions;

   public function loadData(array $data) {
      $this->validate($data);
      $this->id = $data['id'];
      $this->name = $data['name'];
      $this->questions = $data['questions'] ?? null;
   }

   public function validate($data) {
      if (empty($data['id'])) {
         throw new InvalidAssessmentException("ID is required.");
      }
      if (empty($data['name'])) {
         throw new InvalidAssessmentException("Name is required.");
      }
   }

   public function getName() {
      return $this->name;
   }
}
