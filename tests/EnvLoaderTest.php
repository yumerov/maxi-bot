<?php

namespace Yumerov\MaxiBot;

use http\Encoding\Stream\Debrotli;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Exception\EnvNotFoundException;
use Symfony\Component\Dotenv\Dotenv;
use Yumerov\MaxiBot\Mocks\Traits\EnvTrait;

class EnvLoaderTest extends TestCase
{

    private const REQUIRED = [
        'DISCORD_TOKEN' => '0xtoken',
        'GOOD_MORNING_CHANNELS' => '[0]',
        'MAINTAINER' => 1,
        'ALLOWED_SERVERS' => '[2]',
        'MAINTAINER_ONLY_MODE' => 'true'
    ];

    public function test_required(): void
    {
        $this->assertEquals(array_keys(self::REQUIRED), EnvLoader::REQUIRED);
    }

    public function test_valid(): void
    {
        // Act
        $this->initEnvLoader('valid')->load();

        // Assert
        foreach (self::REQUIRED as $key => $value)
        {
            $this->assertEquals($value, $_ENV[$key]);
        }
    }

    public function test_invalid(): void
    {
        // Arrange
        foreach (self::REQUIRED as $key => $value)
        {
            unset($_ENV[$key]);
        }

        // Assert
        $this->expectException(EnvNotFoundException::class);

        // Act
        $this->initEnvLoader('invalid')->load();
    }

    private function initEnvLoader($dir): EnvLoader
    {
        return new EnvLoader(__DIR__ . '/resources/' . $dir, new Dotenv());
    }
}
