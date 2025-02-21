<?php

require_once __DIR__ . '/../models/AppModel.php';

class Student extends AppModel {

   // Properties of the student model
   public string $id;
   public string $firstName;
   public string $lastName;
   public int $yearLevel;

   public function loadData(array $data) {
      $this->id = $data['id'] ?? null;
      $this->firstName = $data['firstName'] ?? null;
      $this->lastName = $data['lastName'] ?? null;
      $this->yearLevel = $data['yearLevel'] ?? null;
   }

   public function getFullName() {
      return $this->firstName . " " . $this->lastName;
   }
}
