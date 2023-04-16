<?php

namespace Yumerov\MaxiBot\Commands;

interface CommandFactoryInterface
{

    public function create(string $class): ?CommandInterface;
}
