<?php

use Yumerov\MaxiBot\Application;

require __DIR__ . '/vendor/autoload.php';

(new Application(__DIR__))
    ->initEnv()
    ->setDiscordToken($_ENV['DISCORD_TOKEN'])
    ->initWrapper()
    ->run();