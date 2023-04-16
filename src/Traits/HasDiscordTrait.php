<?php

namespace Yumerov\MaxiBot\Traits;

use Discord\Discord;

trait HasDiscordTrait
{

    protected Discord $discord;

    public function setDiscord(Discord $discord): static
    {
        $this->discord = $discord;
        return $this;
    }
}
