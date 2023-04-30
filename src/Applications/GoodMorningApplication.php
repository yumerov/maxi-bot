<?php

namespace Yumerov\MaxiBot\Applications;

class GoodMorningApplication extends BaseApplication
{

    protected function setOnReadyAction(): void
    {
        $this->onReadyAction = $this->container->get('GoodMorningAction');
    }
}
