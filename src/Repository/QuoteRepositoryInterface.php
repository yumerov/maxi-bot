<?php

namespace Yumerov\MaxiBot\Repository;

interface QuoteRepositoryInterface
{

    public function getRandomQuote(): ?string;
}
