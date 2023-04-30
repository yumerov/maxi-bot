<?php

namespace Commands;

use Discord\Parts\Interactions\Interaction;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Yumerov\MaxiBot\Commands\RandomQuoteCommand;
use PHPUnit\Framework\TestCase;
use Yumerov\MaxiBot\DTO\QuoteDTO;
use Yumerov\MaxiBot\Repository\QuoteRepositoryInterface;

class RandomQuoteCommandTest extends TestCase
{

    private QuoteRepositoryInterface|MockObject $repository;
    private RandomQuoteCommand $command;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->repository = $this->createMock(QuoteRepositoryInterface::class);
        $this->command = new RandomQuoteCommand($this->repository);
    }

    public function test_getName(): void
    {
        $this->assertEquals('quote', $this->command->getName());
    }

    public function test_getDescription(): void
    {
        $this->assertEquals('Returns a random Bitcoin quote', $this->command->getDescription());
    }

    /**
     * @throws Exception
     */
    public function test_execute(): void
    {
        $interaction = $this->createMock(Interaction::class);
        $quote = new QuoteDTO('Test', 'test');
        $this->repository
            ->expects($this->once())
            ->method('getRandomQuote')
            ->willReturn($quote);
        $interaction->expects($this->once())
            ->method('respondWithMessage');

        $this->command->execute($interaction);
    }

}
