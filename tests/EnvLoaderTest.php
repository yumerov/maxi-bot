<?php

namespace Yumerov\MaxiBot;

use Dotenv\Exception\ValidationException;
use PHPUnit\Framework\TestCase;

class EnvLoaderTest extends TestCase
{

    public function test_required(): void
    {
        $this->assertEquals(['DISCORD_TOKEN'], EnvLoader::REQUIRED);
    }

    public function test_valid(): void
    {
        // Arrange
        $token = '0xtoken';
        $value = 123;

        // Act
        (new EnvLoader(__DIR__ . '/valid'))->load();

        // Assert
        $this->assertEquals($token, $_ENV['DISCORD_TOKEN']);
        $this->assertEquals($value, $_ENV['VALUE']);
    }

    public function test_invalid(): void
    {
        unset($_ENV['DISCORD_TOKEN']);
        (new EnvLoader(__DIR__ . '/invalid'))->load();
        $this->assertNull($_ENV['DISCORD_TOKEN']);
    }
}
