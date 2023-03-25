<?php

namespace Yumerov\MaxiBot\Applications;

use Yumerov\MaxiBot\Actions\OnMessageAction;
use Yumerov\MaxiBot\Actions\OnReadyAction;

class MainApplication extends BaseApplication
{

    protected function setOnReadyAction(): void
    {
        $this->onReadyAction = new OnReadyAction(new OnMessageAction($this->logger), $this->logger);
    }
}
