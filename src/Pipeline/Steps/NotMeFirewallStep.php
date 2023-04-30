<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

class NotMeFirewallStep extends AbstractFirewall
{

    public function allow(): bool
    {
        if ($this->message->author === null) {
            return false;
        }

        $author = $this->message->author;
        if ($author->bot) {
            $this->logger->debug('The author is an bot');
            return false;
        }

        $mentions = $this->message->mentions;
        if ($mentions->count() !== 1) {
            $this->logger->debug('More mentioned users than expected');
            return false;
        }

        if ($mentions->first()->id !== $this->discord->user->id) {
            $this->logger->debug("Not matching the user id: (bot){$this->discord->user->id}<"
                . ">(mentioned){$mentions->first()->id}");
            return false;
        }

        if ($this->message->author->id === $this->discord->user->id) {
            return false;
        }

        return true;
    }
}
