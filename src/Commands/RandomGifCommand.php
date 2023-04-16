<?php

namespace Yumerov\MaxiBot\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Interactions\Interaction;
use Yumerov\MaxiBot\Repository\GifRepositoryInterface;
use Yumerov\MaxiBot\Repository\QuoteRepositoryInterface;

class RandomGifCommand implements CommandInterface
{

    public function __construct(private readonly GifRepositoryInterface $repository)
    {
    }

    public function getName(): string
    {
        return 'gif';
    }

    public function getDescription(): string
    {
        return 'Returns a random Bitcoin gif';
    }

    public function execute(Interaction $interaction): void
    {
        $quote = $this->repository->getRandomGif()->getUrl();
        $message = MessageBuilder::new()->setContent($quote);
        $interaction->respondWithMessage($message);
    }
}
