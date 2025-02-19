#!/usr/bin/env php
<?php

require_once __DIR__ . "/../app/core/CommandHandler.php";

// Handle the command-line input
$commandHandler = new CommandHandler();
$commandHandler->handle($argv);