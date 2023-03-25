<?php

namespace Yumerov\MaxiBot\Applications;

use Yumerov\MaxiBot\Actions\OnMessageAction;
use Yumerov\MaxiBot\Actions\OnReadyAction;

class MainApplication extends BaseApplication
{

    protected function setOnReadyAction(): void
    {
        $onMessageAction = new OnMessageAction($this->logger, $this->env);
        $this->onReadyAction = new OnReadyAction($onMessageAction, $this->logger);
    }
}
