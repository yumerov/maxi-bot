<?php

namespace Yumerov\MaxiBot\Mocks;

use Discord\Parts\User\User as RealUser;

class User extends RealUser
{

    public function __construct(public readonly string $id)
    {
    }
}
