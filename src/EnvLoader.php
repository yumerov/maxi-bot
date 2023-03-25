<?php

namespace Yumerov\MaxiBot;

use Dotenv\Dotenv;

class EnvLoader
{

    public const REQUIRED = ['DISCORD_TOKEN', 'GOOD_MORNING_CHANNELS'];

    public function __construct(private readonly string $rootDir)
    {
    }

    public function load(): void
    {
        $dotenv = Dotenv::createImmutable($this->rootDir);
        $dotenv->load();
        $dotenv->required(self::REQUIRED);
    }
}
