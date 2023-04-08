<?php

namespace Yumerov\MaxiBot\Applications;

class MainApplication extends BaseApplication
{

    protected function setOnReadyAction(): void
    {
        $this->onReadyAction = $this->container->get('OnReadyAction');
    }
}
