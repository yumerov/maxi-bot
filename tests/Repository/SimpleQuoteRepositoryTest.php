<?php

namespace Yumerov\MaxiBot\Repository;

use Yumerov\MaxiBot\Repository\SimpleQuoteRepository;
use PHPUnit\Framework\TestCase;

class SimpleQuoteRepositoryTest extends TestCase
{

    public function test_getRandomQuote(): void
    {
        // Arrange
        $path = dirname(__DIR__) . '/resources/quotes.php';
        $quotes = require $path;
        $repository = new SimpleQuoteRepository($path);

        // Act
        $quote = $repository->getRandomQuote();

        // Assert
        $this->assertContains($quote->getContent(), array_keys($quotes));
        $this->assertEquals($quotes[$quote->getContent()], $quote->getAuthor());
    }
}
