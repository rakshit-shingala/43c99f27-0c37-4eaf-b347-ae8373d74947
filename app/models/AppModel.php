<?php

abstract class AppModel {

   public function __construct(array $data = []) {
      if (!empty($data)) {
         $this->loadData($data);
      }
   }

   abstract public function loadData(array $data);
}
