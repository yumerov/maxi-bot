<?php

namespace Yumerov\MaxiBot\DTO;

class QuoteDTO implements QuoteInterface
{

    public function __construct(
        private readonly string $content,
        private readonly string $author,
    ) {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }
}
