<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Model\Broadcast;

use App\Entity\Product;
use App\Model\Broadcast\ProductDataProcessor;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Sample\Request\BroadcastListener\BroadcastProductRequest;
use Symfony\Sample\Request\BroadcastListener\Product\ListPrice;

/**
 * @coversDefaultClass \App\Model\Broadcast\ProductDataProcessor
 */
class ProductDataProcessorTest extends MockeryTestCase
{
    private ProductDataProcessor $subjectUnderTest;

    public function setUp(): void
    {
        $this->subjectUnderTest = new ProductDataProcessor();
    }

    /**
     * @covers ::process
     */
    public function testProcessSuccess()
    {
        $request = \Mockery::mock(BroadcastProductRequest::class);
        $request->sku = 'P1';
        $request->name = 'Product 1';
        $request->description = 'this is a description';
        $request->isSellable = true;
        $request->stock = 100;
        $request->updatedAt = new \DateTime();
        $request->listPrice = \Mockery::mock(ListPrice::class);
        $request->listPrice->salePrice = 9.99;
        $request->listPrice->specialPrice = 8.99;
        $request->listPrice->specialFrom = new \DateTime('+1 day');
        $request->listPrice->specialTo = new \DateTime('+2 day');

        $product = \Mockery::mock(Product::class);
        $product->shouldReceive('setSku')->once();
        $product->shouldReceive('setName')->once();
        $product->shouldReceive('setStatus')->once();
        $product->shouldReceive('setStock')->once();
        $product->shouldReceive('setPrice')->once();
        $product->shouldReceive('setLastUpdatedAt')->once();
        $product->shouldReceive('setDescription')->once();
        $product->shouldReceive('setSpecialPrice')->once();
        $product->shouldReceive('setSpecialFrom')->once();
        $product->shouldReceive('setSpecialTo')->once();

        $this->subjectUnderTest->process($product, $request);
    }
}
