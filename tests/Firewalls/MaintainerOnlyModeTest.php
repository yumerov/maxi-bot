<?php

namespace Yumerov\MaxiBot\Firewalls;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Mocks\Message;

class MaintainerOnlyModeTest extends TestCase
{
    private Message $message;

    protected function setUp(): void
    {
        $this->message = new Message();
    }

    /**
     * @throws Exception
     */
    public function test_null_author(): void
    {
        $this->assertTrue($this->initFirewall('true')->allow());
    }

    /**
     * @throws Exception
     */
    public function test_maintainer_only_mode_false(): void
    {
        $this->assertTrue($this->initFirewall('false')->allow());
    }

    /**
     * @throws Exception
     */
    private function initFirewall(string $maintainerOnlyMode): MaintainerOnlyMode
    {
        return new MaintainerOnlyMode(
            $this->message,
            $this->createMock(LoggerInterface::class),
            ['MAINTAINER_ONLY_MODE' => $maintainerOnlyMode]
        );
    }
}
