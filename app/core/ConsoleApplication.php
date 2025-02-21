<?php

class ConsoleApplication {

   // Hold the single instance of the ConsoleApplication class.
   private static ?ConsoleApplication $instance = null;
   // Array to store configuration parameters.
   private array $params;

   private function __construct() {
      // Load the parameters from the config file.
      $this->params = require __DIR__ . '/../config/params.php';
   }

   // Public method to access the single instance.
   public static function getInstance(): ConsoleApplication {
      if (self::$instance === null) {
         self::$instance = new ConsoleApplication();
      }
      return self::$instance;
   }

   // Method to get a parameter value
   public function getParam(string $key, $default = null) {
      return $this->params[$key] ?? $default;
   }

   public function getDataSource() {
      $source = $this->params['data_source'];

      return new $source['class']($source['location']);
   }
}
