<?php

namespace Yumerov\MaxiBot\Mocks;

use Discord\Discord as RealDiscord;
use Discord\Parts\User\User as DiscordUser;

class Discord extends RealDiscord
{

    public ?DiscordUser $user = null;
    public function __construct()
    {
    }

}
