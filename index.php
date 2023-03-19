<?php

use Yumerov\MaxiBot\Application;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('DISCORD_TOKEN');

(new Application(
    $_ENV['DISCORD_TOKEN']
))->run();