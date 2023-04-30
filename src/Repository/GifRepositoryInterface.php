<?php

namespace Yumerov\MaxiBot\Repository;

use Yumerov\MaxiBot\DTO\GifInterface;

interface GifRepositoryInterface
{

    public function getRandomGif(): ?GifInterface;
}
