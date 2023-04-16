<?php

namespace Yumerov\MaxiBot\Repository;

use Yumerov\MaxiBot\DTO\QuoteInterface;

interface QuoteRepositoryInterface
{

    public function getRandomQuote(): ?QuoteInterface;
}
