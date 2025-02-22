<?php

class DateTimeHandler {

   public static function convertDate(string $completedDate, string $type = 'long') {
      $app = ConsoleApplication::getInstance();
      $search = $type === 'long' ? 'display_date_format_long' : 'display_date_format_short';
      $date = DateTime::createFromFormat($app->getParam("saved_date_format"), $completedDate);

      // Check if the date conversion was successful
      if ($date) {
         return $date->format($app->getParam($search));
      } else {
         echo "Invalid date format.";
         exit;
      }
   }

   /**
    * Compares $date2 with $date1 to check if its recent date.
    * 
    * @param string $date1
    * @param string $date2
    * @param string $format
    * @return boolean
    */
   public static function isRecent(string $date1, string $date2, string $format) {
      // Create DateTime objects from the date strings
      $date1Obj = DateTime::createFromFormat($format, $date1);
      $date2Obj = DateTime::createFromFormat($format, $date2);

      if (!$date1Obj || !$date2Obj) {
         echo "Error: One or both dates are in an incorrect format.";
         exit;
      }

      return $date2Obj > $date1Obj;
   }

   /**
    * Compares $date2 with $date1 to check if its older date.
    * 
    * @param string $date1
    * @param string $date2
    * @param string $format
    * @return boolean
    */
   public static function isOlder(string $date1, string $date2, string $format) {
      // Create DateTime objects from the date strings
      $date1Obj = DateTime::createFromFormat($format, $date1);
      $date2Obj = DateTime::createFromFormat($format, $date2);

      if (!$date1Obj || !$date2Obj) {
         echo "Error: One or both dates are in an incorrect format.";
         exit;
      }

      return $date2Obj < $date1Obj;
   }
}
