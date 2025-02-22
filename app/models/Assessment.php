<?php

require_once __DIR__ . '/../models/AppModel.php';

class Assessment extends AppModel {

   // Properties of the assessment model
   public string $id;
   public string $name;
   public array $questions;

   public function loadData(array $data) {
      $this->id = $data['id'] ?? null;
      $this->name = $data['name'] ?? null;
      $this->questions = $data['questions'] ?? null;
   }

   public function getName() {
      if (empty($this->name)) {
         echo "Name is not set for $this->id.\n";
         exit;
      }

      return $this->name;
   }
}
