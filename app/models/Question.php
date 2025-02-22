<?php

require_once __DIR__ . '/../models/AppModel.php';
require_once __DIR__ . '/../core/exceptions/InvalidQuestionException.php';

class Question extends AppModel {

   // Properties of the question model
   public string $id;
   public string $stem;
   public string $type;
   public string $strand;
   public array $config;

   public function loadData(array $data) {
      $this->validate($data);
      $this->id = $data['id'];
      $this->stem = $data['stem'];
      $this->type = $data['type'] ?? null;
      $this->strand = $data['strand'];
      $this->config = $data['config'];
   }

   public function validate($data) {
      if (empty($data['id'])) {
         throw new InvalidQuestionException("ID is required.");
      }
      if (empty($data['stem'])) {
         throw new InvalidQuestionException("Stem is required.");
      }
      if (empty($data['strand'])) {
         throw new InvalidQuestionException("Strand is required.");
      }
      if (empty($data['config'])) {
         throw new InvalidQuestionException("Config is required.");
      }
      if (empty($data['config']['key'])) {
         throw new InvalidQuestionException("Answer key is required.");
      }
      if (empty($data['config']['hint'])) {
         throw new InvalidQuestionException("Hint is required.");
      }
      if (empty($data['config']['options'])) {
         throw new InvalidQuestionException("Options are required.");
      }
   }

   public function getCorrectAnswer() {
      return $this->config['key'];
   }

   public function getStem() {
      return $this->stem;
   }

   public function getHint() {
      return $this->config['hint'];
   }

   public function getStrand() {
      return $this->strand;
   }

   public function getOptions() {
      return $this->config['options'];
   }

   public function getOption($optionID) {
      $options = $this->getOptions();
      $index = array_search($optionID, array_column($options, 'id'));

      return $index === false ? null : $options[$index];
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
