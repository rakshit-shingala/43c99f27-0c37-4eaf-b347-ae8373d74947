<?php

abstract class DataSource {

   abstract public function getStudentById(string $studentID);

   abstract public function getStudentResponses();

   abstract public function getRecentlyCompletedStudentAssessment(string $studentID);

   abstract public function getOldestCompletedStudentAssessment(string $studentID);

   abstract public function getCompletedStudentAssessments(string $studentID);

   abstract public function getAssessmentById(string $assessmentID);

   abstract public function getQuestions();
}
