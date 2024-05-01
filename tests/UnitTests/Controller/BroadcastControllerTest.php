<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Controller;

use App\Controller\BroadcastController;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Sample\Request\BroadcastListener\BroadcastProductRequest;

/**
 * @coversDefaultClass \App\Controller\BroadcastController
 */
class BroadcastControllerTest extends MockeryTestCase
{
    private MessageBusInterface|MockObject $messageBus;

    private BroadcastController $subjectUnderTest;

    public function setUp(): void
    {
        $this->messageBus = \Mockery::mock(MessageBusInterface::class);

        $this->subjectUnderTest = new BroadcastController($this->messageBus);
    }

    /**
     * @covers ::__construct
     * @covers ::broadcastProduct
     */
    public function testBroadcastProductSuccess()
    {
        $request = \Mockery::mock(BroadcastProductRequest::class);

        $this->messageBus
            ->shouldReceive('dispatch')
            ->with($request)
            ->once()
            ->andReturn(new Envelope(new \stdClass()));

        $response = $this->subjectUnderTest->broadcastProduct($request);
        $this->assertEquals($response->getStatusCode(), 202);
    }
}
