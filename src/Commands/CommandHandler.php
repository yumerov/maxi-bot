<?php

namespace Yumerov\MaxiBot\Commands;

use Discord\Discord;
use Discord\Parts\Interactions\Command\Command;
use Yumerov\MaxiBot\Exceptions\Exception;

class CommandHandler implements CommandHandlerInterface
{

    public function __construct(
        private readonly CommandFactoryInterface $factory
    ) {
    }

    private array $commands = [
        RandomQuoteCommand::class,
        RandomGifCommand::class,
    ];

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function iterate(Discord $discord): void
    {
        foreach ($this->commands as $command) {
            $command = $this->factory->create($command);

            if ($command === null) {
                throw new Exception("Class '$command' not found");
            }

            $discord->application->commands->save(new Command($discord, [
                'name' => $command->getName(),
                'description' => $command->getDescription()
            ]));
            $discord->listenCommand($command->getName(), [$command, 'execute']);
        }
    }
}
