<?php

namespace Pipeline\Steps;

use PHPUnit\Framework\MockObject\Exception;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Mocks\Discord;
use Yumerov\MaxiBot\Mocks\Message;
use Yumerov\MaxiBot\Mocks\User;
use Yumerov\MaxiBot\Pipeline\Steps\GoodMorningReactionStep;
use PHPUnit\Framework\TestCase;

class GoodMorningReactionStepTest extends TestCase
{

    private static string $coffeeEmoji = '☕';
    private GoodMorningReactionStep $step;
    private Message $message;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->message = new Message();

        $this->step = new GoodMorningReactionStep($this->createMock(LoggerInterface::class));
        $this->step->setDiscord($this->createMock(Discord::class));
        $this->step->setMessage($this->message);
    }

    public function test_stops(): void
    {
        $this->assertFalse($this->step->stops());
    }

    /**
     * @return void
     */
    public function test_execute_bot(): void
    {
        // Arrange
        $this->message->content = self::getProvider()[0][0];
        $this->message->author = new User('1');
        $this->message->author->bot = true;

        // Act
        $this->step->execute();

        // Assert
        $this->assertEmpty($this->message->reactions);
    }

    /**
     * @dataProvider getProvider
     * @param string $greeting
     * @return void
     */
    public function test_execute_react(string $greeting): void
    {
        // Arrange
        $this->message->content = $greeting;

        // Act
        $this->step->execute();

        // Assert
        $this->assertEquals(self::$coffeeEmoji, $this->message->reactions[0]);
    }

    public static function getProvider(): array
    {
        return [
            ['Добро утро!'],
            ['добро утро :)'],
            ['добро утро ☕'],
            ['гуд морнинг'],
            ['Морнинг']
        ];
    }
}
