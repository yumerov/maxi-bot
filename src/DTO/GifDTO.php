<?php

namespace Yumerov\MaxiBot\DTO;

class GifDTO implements GifInterface
{

    public function __construct(private readonly string $url)
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
