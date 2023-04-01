<?php

namespace Yumerov\MaxiBot\Pipeline;

class MaintainerOnlyModeStep extends AbstractFirewall
{

    public function allow(): bool
    {
        if ($this->message->author === null) {
            return true;
        }

        if (strtolower($this->env->maintainerOnlyMode) !== 'true') {
            return true;
        }

        $maintainer = $this->env->maintainer;
        $authorId = $this->message->author->id;
        if ($authorId !== $maintainer) {
            $this->logger->warning("Non maintainer suer($authorId) called the bot!");
            $this->message->reply('Maintainer only mode is ON. Please z tip and DM <@' . $maintainer . '>');
            return false;
        }

        return true;
    }
}
