<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Messenger\Handler;

use App\Entity\Product;
use App\Messenger\Handler\BroadcastProductHandler;
use App\Model\Broadcast\ProductDataProcessor;
use App\Repository\ProductRepository;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Symfony\Sample\Request\BroadcastListener\BroadcastProductRequest;

/**
 * @coversDefaultClass \App\Messenger\Handler\BroadcastProductHandler
 */
class BroadcastProductHandlerTest extends MockeryTestCase
{
    private ProductRepository|MockObject $productRepository;

    private ProductDataProcessor|MockObject $dataProcessor;

    private LoggerInterface|MockObject $logger;

    private BroadcastProductHandler $subjectUnderTest;

    public function setUp(): void
    {
        $this->productRepository = \Mockery::mock(ProductRepository::class);
        $this->dataProcessor = \Mockery::mock(ProductDataProcessor::class);
        $this->logger = \Mockery::mock(LoggerInterface::class);

        $this->subjectUnderTest = new BroadcastProductHandler(
            $this->productRepository,
            $this->dataProcessor,
            $this->logger,
        );
    }

    /**
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testCreateNewProductSuccess()
    {
        $request = \Mockery::mock(BroadcastProductRequest::class);
        $request->sku = 'P1';

        $this->productRepository
            ->shouldReceive('findBySku')
            ->with($request->sku)
            ->once()
            ->andReturnNull();

        $this->dataProcessor
            ->shouldReceive('process')
            ->once();

        $this->productRepository
            ->shouldReceive('saveOne')
            ->once();

        $this->subjectUnderTest->__invoke($request);
    }

    /**
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testUpdateProductSuccess()
    {
        $request = \Mockery::mock(BroadcastProductRequest::class);
        $request->sku = 'P1';
        $request->updatedAt = new \DateTime();

        $product = \Mockery::mock(Product::class);
        $product->lastUpdatedAt = new \DateTime('-1 day');

        $this->productRepository
            ->shouldReceive('findBySku')
            ->with($request->sku)
            ->once()
            ->andReturn($product);

        $this->dataProcessor
            ->shouldReceive('process')
            ->once();

        $this->productRepository
            ->shouldReceive('saveOne')
            ->once();

        $this->subjectUnderTest->__invoke($request);
    }

    /**
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testSkipUpdateProduct()
    {
        $request = \Mockery::mock(BroadcastProductRequest::class);
        $request->sku = 'P1';
        $request->updatedAt = new \DateTime('-2 days');
        $request
            ->shouldReceive('getContext')
            ->once()
            ->andReturn([]);

        $product = \Mockery::mock(Product::class);
        $product->lastUpdatedAt = new \DateTime('-1 day');

        $this->productRepository
            ->shouldReceive('findBySku')
            ->with($request->sku)
            ->once()
            ->andReturn($product);

        $this->dataProcessor
            ->shouldNotReceive('process');

        $this->productRepository
            ->shouldNotReceive('saveOne');

        $this->logger
            ->shouldReceive('info')
            ->with(BroadcastProductHandler::OUT_OF_DATE_REQUEST_MESSAGE, [])
            ->once();

        $this->subjectUnderTest->__invoke($request);
    }

    /**
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testUpdateProductThrowException()
    {
        $request = \Mockery::mock(BroadcastProductRequest::class);
        $request->sku = 'P1';
        $request->updatedAt = new \DateTime();
        $request
            ->shouldReceive('getContext')
            ->once()
            ->andReturn([]);

        $product = \Mockery::mock(Product::class);
        $product->lastUpdatedAt = new \DateTime('-1 day');

        $this->productRepository
            ->shouldReceive('findBySku')
            ->with($request->sku)
            ->once()
            ->andReturn($product);

        $this->dataProcessor
            ->shouldReceive('process')
            ->once();

        $exception = new \Exception();
        $this->productRepository
            ->shouldReceive('saveOne')
            ->once()
            ->andThrow($exception);

        $this->logger
            ->shouldReceive('error')
            ->with($exception, [])
            ->once();

        $this->expectException($exception::class);

        $this->subjectUnderTest->__invoke($request);
    }
}
