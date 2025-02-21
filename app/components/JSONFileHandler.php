<?php

require_once __DIR__ . '/../core/DataSource.php';

class JSONFileHandler {

   private $filePath;
   private $primaryKey;

   // Constructor to set the file path
   public function __construct($filePath, $primaryKey) {
      $this->filePath = $filePath;
      $this->primaryKey = $primaryKey;
   }

   public function readAll() {
      if (!file_exists($this->filePath)) {
         return [];
      }

      $jsonData = file_get_contents($this->filePath);
      return json_decode($jsonData, true) ?? [];
   }

   public function readAllById($id) {
      // Read all data
      $objects = $this->readAll();

      // Create an empty array
      $data = [];
      foreach ($objects as $object) {

         // Select data if id matches
         if ($object[$this->primaryKey] == $id) {
            $data[] = $object;
         }
      }

      return $data;
   }

   public function readOne($id) {
      // Read all data
      $objects = $this->readAll();

      foreach ($objects as $object) {
         if ($object[$this->primaryKey] == $id) {
            return $object;
         }
      }

      return null;
   }
}
