<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

trait NonStoppingStepTrait
{

    public function stops(): bool
    {
        return false;
    }
}
