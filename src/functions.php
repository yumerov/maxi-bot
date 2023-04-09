<?php

use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\ContainerLoader;

function dd($arg): void
{
    var_dump($arg);
    die;
}

/**
 * @return LoggerInterface
 * @throws \Yumerov\MaxiBot\Exceptions\Exception
 * @throws Exception
 */
function logger(): LoggerInterface
{
    return ContainerLoader::getInstance()->get('Logger');
}
