<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

class CheersReactionStep extends OnMessageReactStep
{
    public function getMessageFragments(): array
    {
        return [
            'наздраве',
            'чиърс',
            'cheers',
        ];
    }

    public function getReactionEmoji(): string
    {
        return '🍺';
    }
}
