<?php

namespace Yumerov\MaxiBot\Applications;

use Yumerov\MaxiBot\Actions\OnReadyAction;

class MainApplication extends BaseApplication
{

    public function __construct(string $rootDir)
    {
        parent::__construct($rootDir);
        $this->onReadyAction = new OnReadyAction();
    }
}
