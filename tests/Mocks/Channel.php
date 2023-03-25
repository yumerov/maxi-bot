<?php

namespace Yumerov\MaxiBot\Mocks;

use Discord\Discord;
use Discord\Parts\Channel\Channel as RealChanel;
use Discord\Parts\Channel\Message;
use React\Promise\ExtendedPromiseInterface;

class Channel extends RealChanel
{

    public string $message;

    public function __construct(public readonly string $id)
    {
    }

    public function sendMessage($message, bool $tts = false, $embed = null, $allowed_mentions = null, ?Message $replyTo = null): ExtendedPromiseInterface
    {
        $this->message = $message;

        return new ExtendedPromise();
    }
}
