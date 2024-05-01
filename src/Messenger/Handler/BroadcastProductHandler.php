<?php

declare(strict_types=1);

namespace App\Messenger\Handler;

use App\Entity\Product;
use App\Model\Broadcast\ProductDataProcessor;
use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Sample\Request\BroadcastListener\BroadcastProductRequest;

class BroadcastProductHandler implements MessageHandlerInterface
{
    public const OUT_OF_DATE_REQUEST_MESSAGE = 'BroadcastProductRequest is out of date';
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductDataProcessor $dataProcessor,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(BroadcastProductRequest $request): void
    {
        try {
            $product = $this->productRepository->findBySku($request->sku);
            if (!$product instanceof Product) {
                $product = new Product();
            } elseif ($product->lastUpdatedAt >= $request->updatedAt) {
                $this->logger->info(self::OUT_OF_DATE_REQUEST_MESSAGE, $request->getContext());
                return;
            }

            $this->dataProcessor->process($product, $request);

            $this->productRepository->saveOne($product);
        } catch (\Exception $exception) {
            $this->logger->error($exception, $request->getContext());

            throw $exception;
        }
    }
}
