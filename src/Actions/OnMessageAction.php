<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Parts\Channel\Message;

class OnMessageAction
{

    public function __invoke(Message $message, Discord $discord): void
    {
        if ($message->author->bot) {
            // todo: replace with monolog
            return;
        }

        $mentions = $message->mentions;

        if ($mentions->count() !== 1) {
            // todo: replace with monolog
            return;
        }

        if ($mentions->first()->id !== $discord->user->id) {
            // todo: replace with monolog
            return;
        }

        echo "message here!!!";
        $message->reply('There is no second best!');
    }
}
