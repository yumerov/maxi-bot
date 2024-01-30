<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

class GoodMorningReactionStep extends OnMessageReactStep
{
    public function getMessageFragments(): array
    {
        return [
            'доброутро',
            'морнинг',
        ];
    }

    public function getReactionEmoji(): string
    {
        return '☕';
    }
}
