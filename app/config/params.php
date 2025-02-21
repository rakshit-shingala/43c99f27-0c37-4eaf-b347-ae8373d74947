<?php

return [
   "app_name" => "ACER coding challenge",
   "version" => "1.0.0",
   "data_source" => [
      "class" => "JSONDataSource",
      "location" => [
         "students" => __DIR__ . "/../../storage/data/students.json",
         "assessments" => __DIR__ . "/../../storage/data/assessments.json",
         "questions" => __DIR__ . "/../../storage/data/questions.json",
         "student_responses" => __DIR__ . "/../../storage/data/student-responses.json"
      ]
   ],
   "saved_date_format" => "d/m/Y H:i:s",
   "display_date_format_long" => "jS F Y h:i A",
   "display_date_format_short" => "jS F Y"
];
