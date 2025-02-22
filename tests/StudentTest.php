<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Student.php';

class StudentTest extends TestCase {

   private ?Student $student;
   private array $studentData = [
      'id' => 'student1',
      'firstName' => 'John',
      'lastName' => 'Doe',
      'yearLevel' => 3
   ];

   public function testFullNameReturnsCorrectFormat() {
      $this->assertEquals("John Doe", $this->student->getFullName());
   }

   public function testMandatoryID() {
      $this->expectException(InvalidStudentException::class);
      $testData = $this->studentData;
      unset($testData['id']);
      new Student($testData);
   }

   public function testMandatoryFirstName() {
      $this->expectException(InvalidStudentException::class);
      $testData = $this->studentData;
      unset($testData['firstName']);
      new Student($testData);
   }

   public function testMandatoryLastName() {
      $this->expectException(InvalidStudentException::class);
      $testData = $this->studentData;
      unset($testData['lastName']);
      new Student($testData);
   }

   protected function setUp(): void {
      $this->student = new Student($this->studentData);
   }

   protected function tearDown(): void {
      $this->student = null;
   }
}
