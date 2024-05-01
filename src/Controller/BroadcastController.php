<?php

declare(strict_types=1);

namespace App\Controller;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Sample\Request\BroadcastListener\BroadcastProductRequest;

class BroadcastController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    /**
     * @OA\Tag(name="broadcast-listener")
     * @OA\RequestBody(@Model(type=BroadcastProductRequest::class))
     * @OA\Response(
     *     response=202,
     *     description="Product handled")
     * )
     * @Security(name="basic")
     */
    #[Route(path: '/api/v1/broadcast-listener/product', methods: ['POST'], format: 'json')]
    public function broadcastProduct(BroadcastProductRequest $request): Response
    {
        $this->messageBus->dispatch($request);

        return new Response(null, 202);
    }
}
