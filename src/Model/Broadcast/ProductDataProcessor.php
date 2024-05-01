<?php

declare(strict_types=1);

namespace App\Model\Broadcast;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Sample\Request\BroadcastListener\BroadcastProductRequest;

class ProductDataProcessor
{
    public function process(Product $product, BroadcastProductRequest $request): void
    {
        $product->setSku($request->sku);
        $product->setName($request->name);
        $product->setStatus($request->isSellable);
        $product->setStock($request->stock);
        $product->setPrice($request->listPrice->salePrice);
        $product->setLastUpdatedAt($request->updatedAt);

        if (null !== $request->description) {
            $product->setDescription($request->description);
        }
        if (null !== $request->listPrice->specialPrice) {
            $product->setSpecialPrice($request->listPrice->specialPrice);
        }
        if (null !== $request->listPrice->specialFrom) {
            $product->setSpecialFrom($request->listPrice->specialFrom);
        }
        if (null !== $request->listPrice->specialTo) {
            $product->setSpecialTo($request->listPrice->specialTo);
        }
    }
}
