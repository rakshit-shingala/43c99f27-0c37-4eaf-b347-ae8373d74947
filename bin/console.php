#!/usr/bin/env php
<?php

require_once __DIR__ . "/../app/core/CommandHandler.php";

echo "\n\nWelcome to Rakshit Shingala's PHP CLI application!\n\n\n";

// Handle the command-line input
$commandHandler = new CommandHandler();
$commandHandler->handle($argv);
