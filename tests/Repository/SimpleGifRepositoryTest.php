<?php

namespace Yumerov\MaxiBot\Repository;

use Yumerov\MaxiBot\Repository\SimpleQuoteRepository;
use PHPUnit\Framework\TestCase;

class SimpleGifRepositoryTest extends TestCase
{

    public function test_getRandomGif(): void
    {
        // Arrange
        $path = dirname(__DIR__) . '/resources/gifs.php';
        $gifs = require $path;
        $repository = new SimpleGifRepository($path);

        // Act
        $gif = $repository->getRandomGif()->getUrl();

        // Assert
        $this->assertContains($gif, $gifs);
    }
}
