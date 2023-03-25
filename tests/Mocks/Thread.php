<?php

namespace Yumerov\MaxiBot\Mocks;

use Discord\Discord;
use Discord\Parts\Thread\Thread as RealThread;

class Thread extends RealThread
{

    public function __construct(public readonly string $guild_id)
    {
    }
}
