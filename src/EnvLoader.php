<?php

namespace Yumerov\MaxiBot;

use Symfony\Component\DependencyInjection\Exception\EnvNotFoundException;
use Symfony\Component\Dotenv\Dotenv;

class EnvLoader
{

    public const REQUIRED = [
        'DISCORD_TOKEN',
        'GOOD_MORNING_CHANNELS',
        'MAINTAINER',
        'ALLOWED_SERVERS',
        'MAINTAINER_ONLY_MODE',
    ];

    public function __construct(
        private readonly string $rootDir,
        private readonly Dotenv $dotenv
    ) {
    }

    public function load(): void
    {
        $path = $this->rootDir . '/.env';
        if (!file_exists($path)) {
            return;
        }
        $this->dotenv->load($path);

        foreach (self::REQUIRED as $key) {
            if (isset($_ENV[$key])) {
                return;
            }

            throw new EnvNotFoundException("The env var '$key' is missing");
        }
    }
}
