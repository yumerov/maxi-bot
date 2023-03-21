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
        $this->assertEquals($token, getenv('DISCORD_TOKEN'));
        $this->assertEquals($value, getenv('VALUE'));
    }

    public function test_invalid(): void
    {
        try {
            (new EnvLoader(__DIR__ . '/invalid'))->load();
        } catch (ValidationException $exception) {
            $this->assertEquals('One or more environment variables failed assertions: ' . EnvLoader::REQUIRED[0] . ' is missing.', $exception->getMessage());
        }

        $this->fail();
    }
}
