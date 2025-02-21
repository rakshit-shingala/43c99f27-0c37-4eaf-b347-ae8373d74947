<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Student.php';

class StudentTest extends TestCase {

   public function testFullNameReturnsCorrectFormat() {
      $student = new Student([
         'id' => 'student1',
         'firstName' => 'John',
         'lastName'=> 'Doe',
         'yearLevel' => 3
      ]);

      $this->assertEquals("John Doe", $student->getFullName());
   }
}
