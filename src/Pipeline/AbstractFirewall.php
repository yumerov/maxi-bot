<?php

namespace Yumerov\MaxiBot\Pipeline;

abstract class AbstractFirewall extends AbstractStep implements StepInterface
{

    abstract public function allow(): bool;

    public function stops(): bool
    {
        return !$this->allow();
    }

    public function execute(): void
    {
    }
}
