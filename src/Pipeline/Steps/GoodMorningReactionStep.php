<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

class GoodMorningReactionStep extends OnMessageReactStep
{
    public function getMessageFragments(): array
    {
        return [
            'доброутро',
            'морнинг',
            'goodmorning', // targets gif messages
            'good-morning', // targets gif messages
        ];
    }

    public function getReactionEmoji(): string
    {
        return '☕';
    }
}
