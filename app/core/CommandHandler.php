<?php

require_once __DIR__ . "/../commands/ReportCommand.php";

class CommandHandler {
   private $commands = [
       "report" => ReportCommand::class
   ];

   public function handle($args) {
      if (count($args) < 2) {
         echo "Usage: php bin/console [command] [arguments]\n";
         return;
      }

      $commandName = $args[1];
      $commandArgs = array_slice($args, 2);

      if (isset($this->commands[$commandName])) {
         $command = new $this->commands[$commandName]();
         $command->execute($commandArgs);
      } else {
         echo "Unkown command: $commandName\n";
      }
   }
}
