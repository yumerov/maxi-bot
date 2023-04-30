<?php

namespace Yumerov\MaxiBot\Commands;

use Discord\Discord;

trait NoOptionsCommandTrait
{

    public function getOptions(Discord $discord): array
    {
        return [];
    }
}
