<?php

namespace Yumerov\MaxiBot\Discord;

use Discord\Discord;
use PHPUnit\Framework\TestCase;
use Yumerov\MaxiBot\Actions\OnReadyAction;

class DiscordClientTest extends TestCase
{

    public function test_run(): void
    {
        // Arrange & Arrange
        $action = $this->createMock(OnReadyAction::class);

        $discord = $this->createMock(Discord::class);
        $discord
            ->expects($this->once())
            ->method('on')
            ->with('ready', $action);

        $discord
            ->expects($this->once())
            ->method('run');

        // Act
        $client = new DiscordClient($discord);
        $client->setOnReadyAction($action);
        $client->run();
    }
}
