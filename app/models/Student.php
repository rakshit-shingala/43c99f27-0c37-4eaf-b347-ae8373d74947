<?php

require_once __DIR__ . '/../models/AppModel.php';
require_once __DIR__ . '/../core/exceptions/InvalidStudentException.php';

class Student extends AppModel {

   // Properties of the student model
   public string $id;
   public string $firstName;
   public string $lastName;
   public int $yearLevel;

   public function loadData(array $data) {
      $this->validate($data);
      $this->id = $data['id'];
      $this->firstName = $data['firstName'];
      $this->lastName = $data['lastName'];
      $this->yearLevel = $data['yearLevel'] ?? null;
   }

   public function validate($data) {
      if (empty($data['id'])) {
         throw new InvalidStudentException("ID is required.");
      }
      if (empty($data['firstName']) || empty($data['lastName'])) {
         throw new InvalidStudentException("First name and last name are required.");
      }
   }

   public function getFullName() {
      return $this->firstName . " " . $this->lastName;
   }
}
