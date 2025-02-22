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

   public function getCorrectAnswer() {
      if (empty($this->config) || empty($this->config['key'])) {
         echo "Correct answer is not set for $this->id.\n";
         exit;
      }

      return $this->config['key'];
   }

   public function getStem() {
      if (empty($this->stem)) {
         echo "Stem is not set for $this->id.\n";
         exit;
      }

      return $this->stem;
   }

   public function getHint() {
      if (empty($this->config) || empty($this->config['hint'])) {
         echo "Hint is not set for $this->id.\n";
         exit;
      }

      return $this->config['hint'];
   }

   public function getStrand() {
      if (empty($this->strand)) {
         echo "Strand is not set for $this->id.\n";
         exit;
      }

      return $this->strand;
   }

   public function getOptions() {
      if (empty($this->config) || empty($this->config['options'])) {
         echo "Options is not set for $this->id.\n";
         exit;
      }

      return $this->config['options'];
   }

   public function getOption($optionID) {
      $options = $this->getOptions();
      $index = array_search($optionID, array_column($options, 'id'));
      if ($index === false) {
         echo "Option is missing for $this->id.\n";
         exit;
      }

      return $options[$index];
   }

   public function getCorrectAnswerOption() {
      return $this->getOption($this->getCorrectAnswer());
   }

   public function isAnsweredCorrectly($response) {
      return $response === $this->getCorrectAnswer();
   }

   public function getFeedbackForWrongAnswer($answerID) {
      if (!$this->isAnsweredCorrectly($answerID)) {
         $answerOption = $this->getOption($answerID);
         $correctAnswerOption = $this->getCorrectAnswerOption();

         return strtr("Question: {stem}\n"
               . "Your Answer: {answer_label} with value {answer_value}\n"
               . "Right Answer: {correct_answer_label} with value {correct_answer_value}\n"
               . "Hint: {hint}\n", [
            '{stem}' => $this->getStem(),
            '{answer_label}' => $answerOption['label'],
            '{answer_value}' => $answerOption['value'],
            '{correct_answer_label}' => $correctAnswerOption['label'],
            '{correct_answer_value}' => $correctAnswerOption['value'],
            '{hint}' => $this->getHint()
         ]);
      }

      return null;
   }
}
