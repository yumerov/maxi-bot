<?php

namespace Yumerov\MaxiBot\Mocks;

use React\Promise\ExtendedPromiseInterface;

class ExtendedPromise implements ExtendedPromiseInterface
{

    /**
     * @var callable
     */
    public $always;

    public function done(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        // TODO: Implement done() method.
    }

    public function otherwise(callable $onRejected)
    {
        // TODO: Implement otherwise() method.
    }

    public function always(callable $onFulfilledOrRejected)
    {
        call_user_func($onFulfilledOrRejected);
    }

    public function progress(callable $onProgress)
    {
        // TODO: Implement progress() method.
    }

    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        // TODO: Implement then() method.
    }
}
