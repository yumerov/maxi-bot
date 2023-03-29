<?php

namespace Yumerov\MaxiBot;

use Dotenv\Dotenv;

class EnvLoader
{

    public const REQUIRED = [
        'DISCORD_TOKEN',
        'GOOD_MORNING_CHANNELS',
        'MAINTAINER',
        'ALLOWED_SERVERS',
        'MAINTAINER_ONLY_MODE',
    ];

    public function __construct(private readonly string $rootDir)
    {
    }

    public function load(): void
    {
        if (!file_exists($this->rootDir . '/.env')) {
            return;
        }
        $dotenv = Dotenv::createImmutable($this->rootDir);
        $dotenv->load();
        $dotenv->required(self::REQUIRED);
    }
}
