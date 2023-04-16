<?php

namespace Yumerov\MaxiBot\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Parts\Interactions\Interaction;
use Yumerov\MaxiBot\Repository\QuoteRepositoryInterface;

class RandomQuoteCommand implements CommandInterface
{

    public function __construct(private readonly QuoteRepositoryInterface $repository)
    {
    }

    public function getName(): string
    {
        return 'quote';
    }

    public function getDescription(): string
    {
        return 'Returns a random Bitcoin quote';
    }

    public function execute(Interaction $interaction): void
    {
        $quote = $this->repository->getRandomQuote();
        $message = MessageBuilder::new()->setContent("\"{$quote->getContent()}\"\n\~{$quote->getAuthor()}");
        $interaction->respondWithMessage($message);
    }
}
