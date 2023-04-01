<?php

namespace Yumerov\MaxiBot;

use PHPUnit\Framework\TestCase;
use Yumerov\MaxiBot\Mocks\Traits\EnvTrait;

class EnvLoaderTest extends TestCase
{

    use EnvTrait;

    private const REQUIRED = [
        'DISCORD_TOKEN' => '0xtoken',
        'GOOD_MORNING_CHANNELS' => '["0"]',
        'MAINTAINER' => '1',
        'ALLOWED_SERVERS' => '["2"]',
        'MAINTAINER_ONLY_MODE' => 'true'
    ];

    public function test_required(): void
    {
        $this->assertEquals(array_keys(self::REQUIRED), EnvLoader::REQUIRED);
    }

    public function test_valid(): void
    {
        // Act
        (new EnvLoader(__DIR__ . '/resources/valid'))->load();

        // Assert
        foreach (self::REQUIRED as $key => $value)
        {
            $this->assertEquals($value, $_ENV[$key]);
        }
    }

    public function test_invalid(): void
    {
        // Arrange
        $this->unsetEnv(array_keys(self::REQUIRED));

        // Act
        (new EnvLoader(__DIR__ . '/resources/invalid'))->load();

        // Assert
        foreach (self::REQUIRED as $key => $value)
        {
            $this->assertNull($_ENV[$key]);
        }
    }
}
