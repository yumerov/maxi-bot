<?php

namespace Commands;

use Discord\Discord;
use Discord\Parts\Interactions\Interaction;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Yumerov\MaxiBot\Commands\RandomGifCommand;
use Yumerov\MaxiBot\Commands\RandomQuoteCommand;
use PHPUnit\Framework\TestCase;
use Yumerov\MaxiBot\DTO\GifDTO;
use Yumerov\MaxiBot\DTO\QuoteDTO;
use Yumerov\MaxiBot\Repository\GifRepositoryInterface;
use Yumerov\MaxiBot\Repository\QuoteRepositoryInterface;

class RandomGifCommandTest extends TestCase
{

    private GifRepositoryInterface|MockObject $repository;
    private RandomGifCommand $command;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->repository = $this->createMock(GifRepositoryInterface::class);
        $this->command = new RandomGifCommand($this->repository);
    }

    public function test_getName(): void
    {
        $this->assertEquals('gif', $this->command->getName());
    }

    public function test_getDescription(): void
    {
        $this->assertEquals('Returns a random Bitcoin gif', $this->command->getDescription());
    }

    /**
     * @throws Exception
     */
    public function test_getOptions(): void
    {
        $this->assertEmpty($this->command->getOptions($this->createMock(Discord::class)));
    }

    /**
     * @throws Exception
     */
    public function test_execute(): void
    {
        $interaction = $this->createMock(Interaction::class);
        $gif = new GifDTO('test');
        $this->repository
            ->expects($this->once())
            ->method('getRandomGif')
            ->willReturn($gif);
        $interaction->expects($this->once())
            ->method('respondWithMessage');

        $this->command->execute($interaction);
    }

}
