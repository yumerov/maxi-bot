<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function dd($arg): void
{
    var_dump($arg);
    die;
}

function logger(): void
{

}
