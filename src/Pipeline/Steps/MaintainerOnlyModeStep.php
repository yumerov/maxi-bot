<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

use Psr\Log\LoggerInterface;

class MaintainerOnlyModeStep extends AbstractFirewall
{

    public function __construct(
        protected readonly LoggerInterface $logger,
        protected readonly string $maintainer,
        protected readonly string $maintainerOnlyMode
    ) {
    }
    public function allow(): bool
    {
        if ($this->message->author === null) {
            return true;
        }

        if (strtolower($this->maintainerOnlyMode) !== 'true') {
            return true;
        }

        $authorId = $this->message->author->id;
        if ($authorId !== $this->maintainer) {
            $this->logger->warning("Non maintainer suer($authorId) called the bot!");
            $this->message->reply('Maintainer only mode is ON. Please z tip and DM <@' . $this->maintainer . '>');
            return false;
        }

        return true;
    }
}
