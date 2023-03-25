<?php

namespace Yumerov\MaxiBot\Mocks;

use Discord\Discord as RealDiscord;
use Discord\Parts\User\User as DiscordUser;

class Discord extends RealDiscord
{

    public ?DiscordUser $user = null;
    /**
     * @var Channel[]
     */
    public array $channels = [];
    public function __construct()
    {
    }

    public function getChannel($channel_id): ?Channel
    {
        if ($channel_id === '0') {
            return null;
        }

        $channel = new Channel($channel_id);
        $this->channels[] = $channel;

        return $channel;
    }
}
