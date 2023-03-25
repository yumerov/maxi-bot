<?php

namespace Yumerov\MaxiBot\Mocks;

use Discord\Builders\MessageBuilder;
use Discord\Parts\Channel\Message as RealMessage;
use Discord\Parts\Thread\Thread as DiscordThread;
use Discord\Parts\User\User as DiscordUser;
use React\Promise\ExtendedPromiseInterface;

class Message extends RealMessage
{

    public ?DiscordUser $author = null;
    public ?DiscordThread $channel;
    public string $replyContent;

    public function __construct()
    {
    }

    public function reply($message): ExtendedPromiseInterface
    {
        $this->replyContent = $message;
        return new class implements ExtendedPromiseInterface {

            public function done(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
            {
            }

            public function otherwise(callable $onRejected)
            {
            }

            public function always(callable $onFulfilledOrRejected)
            {
            }

            public function progress(callable $onProgress)
            {
            }

            public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
            {
            }
        };
    }
}
