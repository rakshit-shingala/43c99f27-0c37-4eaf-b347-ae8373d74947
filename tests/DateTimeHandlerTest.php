<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/core/DateTimeHandler.php';

class DateTimeHandlerTest extends TestCase {

   public function testDateTimeFormatConvert() {
      $this->assertEquals("16th December 2021 10:46 AM", DateTimeHandler::convertDate('16/12/2021 10:46:00', 'long'));
      $this->assertEquals("16th December 2021", DateTimeHandler::convertDate('16/12/2021 10:46:00', 'short'));
   }

   public function testDateTimeRecentCompare() {
      $this->assertTrue(DateTimeHandler::isRecent('16/12/2020 10:46:00', '16/12/2021 10:46:00', 'd/m/Y H:i:s'));
      $this->assertFalse(DateTimeHandler::isRecent('16/12/2021 10:46:00', '16/12/2020 10:46:00', 'd/m/Y H:i:s'));
   }

   public function testDateTimeOlderCompare() {
      $this->assertTrue(DateTimeHandler::isOlder('16/12/2021 10:46:00', '16/12/2020 10:46:00', 'd/m/Y H:i:s'));
      $this->assertFalse(DateTimeHandler::isOlder('16/12/2020 10:46:00', '16/12/2021 10:46:00', 'd/m/Y H:i:s'));
   }
}
