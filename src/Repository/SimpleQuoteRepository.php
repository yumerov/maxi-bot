<?php

namespace Yumerov\MaxiBot\Repository;

use Yumerov\MaxiBot\DTO\QuoteDTO;
use Yumerov\MaxiBot\DTO\QuoteInterface;

class SimpleQuoteRepository implements QuoteRepositoryInterface
{

    public function __construct(private readonly string $path)
    {
    }

    public function getRandomQuote(): ?QuoteInterface
    {
        $quotes = require $this->path;
        $quote = array_rand($quotes);
        return new QuoteDTO($quote, $quotes[$quote]);
    }
}
