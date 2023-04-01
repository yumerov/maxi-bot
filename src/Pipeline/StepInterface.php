<?php

namespace Yumerov\MaxiBot\Pipeline;

interface StepInterface
{

    public function execute(): void;
    public function stops(): bool;
}
