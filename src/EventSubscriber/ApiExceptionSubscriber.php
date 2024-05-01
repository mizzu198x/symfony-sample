<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\Http\AbstractContextualException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Sample\ContextualInterface;
use Symfony\Sample\Response\ErrorResponse;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $this->logger->error($exception->__toString());
        $errorResponse = new ErrorResponse();
        $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof AbstractContextualException || $exception instanceof HttpExceptionInterface) {
            $httpCode = $exception->getStatusCode();

            $errorResponse->code = $exception->getCode() ?: $httpCode;
            $errorResponse->message = $exception instanceof AbstractContextualException
                ? $exception->getStatusText()
                : (string) Response::$statusTexts[$httpCode];
            $errorResponse->exceptionMessage = $exception->getMessage();

            if ($exception instanceof ContextualInterface) {
                if (isset($exception->getContext()['errors'])
                    && is_array($exception->getContext()['errors'])) {
                    $errorResponse->errorList = (array) $exception->getContext()['errors'];
                }
            }
        }

        $response = new JsonResponse($errorResponse->toArray(), $httpCode);
        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
