<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Student.php';

class StudentTest extends TestCase {

   private ?Student $student;

   public function testFullNameReturnsCorrectFormat() {
      $this->assertEquals("John Doe", $this->student->getFullName());
   }

   protected function setUp(): void {
      $this->student = new Student([
         'id' => 'student1',
         'firstName' => 'John',
         'lastName'=> 'Doe',
         'yearLevel' => 3
      ]);
   }

   protected function tearDown(): void {
      $this->student = null;
   }
}
