<?php
require '../vendor/autoload.php';

use Nkey\Caribu\Console\CLI;
use Nkey\Caribu\Console\DefaultParser;

$console = new CLI("console");

$input = "";
while ("exit" !== $input) {
    $parsed = $console->readLine();
    $input = $parsed->getCommand();
}
