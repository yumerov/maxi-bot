<?php

namespace Yumerov\MaxiBot\Applications;

use Yumerov\MaxiBot\Actions\GoodMorningAction;
use Yumerov\MaxiBot\Exceptions\Exception;
use Yumerov\MaxiBot\Exceptions\MalformedGoodMorningChannelListException;

class GoodMorningApplication extends BaseApplication
{

    protected array $channels;

    /**
     * @throws Exception
     */
    public function setChannels(): self
    {
        $channels = json_decode($this->env->goodMorningChannels);
        if ($channels === null) {
            throw new MalformedGoodMorningChannelListException();
        }
        $this->channels = $channels;

        return $this;
    }

    protected function setOnReadyAction(): void
    {
        $this->onReadyAction = new GoodMorningAction($this->channels, $this->logger);
    }
}
