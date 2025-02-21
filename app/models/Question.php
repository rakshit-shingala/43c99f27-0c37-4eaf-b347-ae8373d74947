<?php

require_once __DIR__ . '/../models/AppModel.php';

class Question extends AppModel {

   // Properties of the question model
   public string $id;
   public string $stem;
   public string $type;
   public string $strand;
   public array $config;

   public function loadData(array $data) {
      $this->id = $data['id'] ?? null;
      $this->stem = $data['stem'] ?? null;
      $this->type = $data['type'] ?? null;
      $this->strand = $data['strand'] ?? null;
      $this->config = $data['config'] ?? null;
   }

   public function isAnsweredCorrectly($response) {
      if (empty($this->config) || empty($this->config['key'])) {
         echo "Correct answer is not set for a question.\n";
      }

      return $response === $this->config['key'];
   }

   public function getHint() {
      if (empty($this->config) || empty($this->config['hint'])) {
         echo "Hint is not set for a question.\n";
         exit;
      }

      return $this->config['hint'];
   }

   public function getStrand() {
      if (empty($this->strand)) {
         echo "Strand is not set for a question.\n";
         exit;
      }

      return $this->strand;
   }
}
