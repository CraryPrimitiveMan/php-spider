<?php
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/Application.php');

$config = array_merge(
    require(__DIR__ . '/config/main.php'),
    $argv
);
(new Application($config))->run();
