<?php

namespace Yumerov\MaxiBot\Mocks;

use Discord\Builders\MessageBuilder;
use Discord\Helpers\Collection;
use Discord\Parts\Channel\Message as RealMessage;
use Discord\Parts\Thread\Thread as DiscordThread;
use Discord\Parts\User\User;
use Discord\Parts\User\User as DiscordUser;
use React\Promise\ExtendedPromiseInterface;

class Message extends RealMessage
{

    public ?DiscordUser $author = null;
    public ?DiscordThread $channel;
    /**
     * @var Collection|DiscordUser[]
     */
    public $mentions;
    public string $replyContent;
    public string $content;
    public array $reactions;

    public function __construct()
    {
        $this->mentions = new Collection();
    }

    public function reply($message): ExtendedPromiseInterface
    {
        $this->replyContent = $message;

        return $this->getExtendedPromise();
    }

    public function react($emoticon): ExtendedPromiseInterface
    {
        $this->reactions[] = $emoticon;

        return $this->getExtendedPromise();
    }

    private function getExtendedPromise(): ExtendedPromiseInterface
    {
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
