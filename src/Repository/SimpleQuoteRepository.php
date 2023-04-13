<?php

namespace Yumerov\MaxiBot\Repository;

class SimpleQuoteRepository implements QuoteRepositoryInterface
{

    public function __construct(private readonly string $path)
    {
    }

    public function getRandomQuote(): ?string
    {
        $quotes = require $this->path;

        return $quotes[array_rand($quotes)];
    }
}
