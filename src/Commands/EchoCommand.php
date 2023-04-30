<?php

namespace Yumerov\MaxiBot\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Http\Exceptions\NoPermissionsException;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;

class EchoCommand implements CommandInterface
{

    public function getName(): string
    {
        return 'echo';
    }

    public function getDescription(): string
    {
        return 'Prints the entered message';
    }

    /**
     * @throws NoPermissionsException
     */
    public function execute(Interaction $interaction): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->setContent('Echoed'), true);
        $interaction->channel->sendMessage($interaction->data->options['message']->value);
    }

    public function getOptions(Discord $discord): array
    {
        return [
            (new Option($discord))
                ->setName('message')
                ->setDescription('Greeting message')
                ->setType(Option::STRING)
                ->setRequired(true)
        ];
    }
}
