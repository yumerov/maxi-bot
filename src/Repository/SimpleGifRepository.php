<?php

namespace Yumerov\MaxiBot\Repository;

use Yumerov\MaxiBot\DTO\GifDTO;
use Yumerov\MaxiBot\DTO\GifInterface;

class SimpleGifRepository implements GifRepositoryInterface
{

    public function __construct(private readonly string $path)
    {
    }

    public function getRandomGif(): ?GifInterface
    {
        $gifs = require $this->path;
        return new GifDTO($gifs[array_rand($gifs)]);
    }
}
