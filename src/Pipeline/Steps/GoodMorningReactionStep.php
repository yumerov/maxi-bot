<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

class GoodMorningReactionStep extends AbstractStep implements StepInterface
{

    use NonStoppingStepTrait;

    private const GOOD_MORNING_GREETINGS = [
        'доброутро',
        'морнинг'
    ];
    private const COFFEE_EMOJI = '☕';

    public function execute(): void
    {
        $content = mb_strtolower(str_replace(' ', '', $this->message->content));

        echo $content . "\n";

        foreach (self::GOOD_MORNING_GREETINGS as $greeting) {
            if (str_contains($content, $greeting)) {
                $this->message->react(self::COFFEE_EMOJI);
            }
        }
    }
}
