<?php

/**
 * Set of functions for debugging and quick prototyping
 */

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
    return get('Logger');
}

/**
 * @throws \Yumerov\MaxiBot\Exceptions\Exception
 * @throws Exception
 */
function get(string $id)
{
    return ContainerLoader::getInstance()->get($id);
}
