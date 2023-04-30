<?php

namespace Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Http\Exceptions\NoPermissionsException;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Interactions\Request\InteractionData;
use Discord\Repository\Interaction\OptionRepository;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;
use Yumerov\MaxiBot\Commands\EchoCommand;
use PHPUnit\Framework\TestCase;

class EchoCommandTest extends TestCase
{

    private Discord|MockObject $discord;
    private EchoCommand $command;

    /**
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->discord = $this->createMock(Discord::class);
        $this->command = new EchoCommand();
    }

    public function test_getName()
    {
        $this->assertEquals('echo', $this->command->getName());
    }

    public function test_getDescription()
    {
        $this->assertEquals('Prints the entered message', $this->command->getDescription());
    }

    public function test_getOptions()
    {
        $options = $this->command->getOptions($this->discord);
        $this->assertEquals(1, count($options));
        $this->assertEquals('message', $options[0]->name);
    }

    /**
     * @throws NoPermissionsException
     * @throws Exception
     */
    public function test_execute()
    {
        // Arrange
        $message = new stdClass();
        $message->value = 'hola';
        $optionRepository = $this->createMock(OptionRepository::class);
        $interactionData = $this->createMock(InteractionData::class);
        $interaction = $this->createMock(Interaction::class);
        $channel = $this->createMock(Channel::class);

        //Assert
        $optionRepository
            ->expects($this->once())
            ->method('offsetGet')
            ->with('option')
            ->willReturn($message);
        $interaction
            ->expects($this->once())
            ->method('respondWithMessage')
            ->with(MessageBuilder::new()->setContent('Echoed'), true);
        $channel
            ->expects($this->once())
            ->method('sendMessage')
            ->with($message->value);
        $interaction
            ->expects($this->once())
            ->method('__get')
            ->with('channel')
            ->willReturn($channel);
        $interaction
            ->expects($this->once())
            ->method('__get')
            ->with('data')
            ->willReturn($interactionData);

        // Act
        $this->command->execute($interaction);;
    }
}
