<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\EventSubscriber;

use App\Infrastructure\Driven\JsonApi\ErrorHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Undabot\SymfonyJsonApi\Exception\ParamConverterInvalidUuidFormatException;
use Undabot\SymfonyJsonApi\Http\Model\Response\JsonApiHttpResponse;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(private ErrorHandler $errorHandler)
    {
    }

    /** @return array<string, string> */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'buildErrorResponse',
        ];
    }

    public function buildErrorResponse(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = match (true) {
            $exception instanceof ParamConverterInvalidUuidFormatException,
            $exception instanceof NotFoundHttpException, => JsonApiHttpResponse::notFound(),
            $exception instanceof AccessDeniedHttpException, => JsonApiHttpResponse::forbidden($this->errorHandler->buildError($exception)),
            $exception instanceof \DomainException,
            $exception instanceof \InvalidArgumentException, => JsonApiHttpResponse::badRequest($this->errorHandler->buildError($exception)),
            default => null,
        };

        if (null !== $response) {
            $event->setResponse($response);
        }
    }
}
