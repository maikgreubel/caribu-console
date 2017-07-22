<?php
require '../vendor/autoload.php';

use Nkey\Caribu\Console\CLI;

$console = new CLI("console");

$input = "";
while ("exit" !== $input) {
    $parsed = $console->readLine();
    $input = $parsed->getCommand();
}
