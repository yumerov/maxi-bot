<?php

namespace Yumerov\MaxiBot\DTO;

interface QuoteInterface
{

    public function getContent(): string;
    public function getAuthor(): string;
}
