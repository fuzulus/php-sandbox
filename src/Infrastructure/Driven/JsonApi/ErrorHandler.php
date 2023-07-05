<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\JsonApi;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Undabot\JsonApi\Definition\Encoding\DocumentToPhpArrayEncoderInterface;
use Undabot\JsonApi\Implementation\Model\Document\Document;
use Undabot\JsonApi\Implementation\Model\Error\Error;
use Undabot\JsonApi\Implementation\Model\Error\ErrorCollection;

final class ErrorHandler
{
    public function __construct(
        private readonly DocumentToPhpArrayEncoderInterface $documentToPhpArrayEncoder,
    ) {
    }

    /** @return mixed[] */
    public function buildError(\Throwable $exception): array
    {
        $errorCollection = new ErrorCollection([
            $this->buildErrorFromException($exception),
        ]);
        $document = new Document(null, $errorCollection);

        return $this->documentToPhpArrayEncoder->encode($document);
    }

    private function buildErrorFromException(\Throwable $exception): Error
    {
        $class = (new \ReflectionClass($exception))->getShortName();

        $e = FlattenException::createFromThrowable($exception);

        return new Error(
            null,
            null,
            null,
            (string) $e->getCode(),
            $e->getMessage(),
            sprintf(
                'Exception %s: "%s"',
                $class,
                $e->getMessage()
            )
        );
    }
}
