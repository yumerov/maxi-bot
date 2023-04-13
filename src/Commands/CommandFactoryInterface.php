<?php

namespace Yumerov\MaxiBot\Commands;

use Discord\Discord;

interface CommandFactoryInterface
{

    public function create(string $class): ?CommandInterface;
}
