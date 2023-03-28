<?php

namespace Yumerov\MaxiBot\Applications;

use Yumerov\MaxiBot\Actions\GoodMorningAction;
use Yumerov\MaxiBot\Exceptions\Exception;

class GoodMorningApplication extends BaseApplication
{

    private array $channels;

    /**
     * @throws Exception
     */
    public function setChannels(): self
    {
        $channels = json_decode($this->env['GOOD_MORNING_CHANNELS']);
        if ($channels === null) {
            throw new Exception('Malformed good morning channel list');
        }
        $this->channels = $channels;

        return $this;
    }

    protected function setOnReadyAction(): void
    {
        $this->onReadyAction = new GoodMorningAction($this->channels, $this->logger);
    }
}
