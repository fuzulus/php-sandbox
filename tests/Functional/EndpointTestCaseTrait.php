<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Assert\Assertion;
use GuzzleHttp\Psr7\Request;
use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @coversNothing
 *
 * @small
 */
trait EndpointTestCaseTrait
{
    /** @return array<string,string> */
    public function requestHeaders(): array
    {
        return [
            'Content-Type' => 'application/vnd.api+json',
        ];
    }

    abstract protected function validatorBuilder(): ValidatorBuilder;

    protected static function createValidatorBuilder(): ValidatorBuilder
    {
        return (new ValidatorBuilder())->fromYamlFile(__DIR__ . '/../../docs/open_api.yaml');
    }

    /** @param mixed[] $body */
    protected function prepareBody(array $body): string
    {
        $encodedBody = json_encode($body, JSON_THROW_ON_ERROR);
        Assertion::isJsonString($encodedBody);

        return $encodedBody;
    }

    protected function validateRequest(Request $request): void
    {
        $this->validatorBuilder()->getRequestValidator()->validate($request);
    }

    protected function validateOperation(Request $request, string $path, ResponseInterface $response): void
    {
        $responseValidator = $this->validatorBuilder()->getResponseValidator();

        $operation = new OperationAddress($path, mb_strtolower($request->getMethod()));
        $responseValidator->validate($operation, $response);
    }

    /** @return array<string, string> */
    private function prepareHeaders(RequestInterface $request): array
    {
        $headers = $request->getHeaders();
        $preparedHeaders = [];

        foreach ($headers as $header => $value) {
            $fastCgiHeader = 'HTTP_' . mb_strtoupper(str_replace('-', '_', $header));

            $preparedHeaders[$fastCgiHeader] = $value[0];
        }

        return $preparedHeaders;
    }

    /** @return array<string,string> */
    private function prepareQueryParameters(RequestInterface $request): array
    {
        $query = parse_url((string) $request->getUri(), PHP_URL_QUERY);

        if (true === empty($query)) {
            return [];
        }

        return array_reduce(
            explode('&', $query),
            static function (array $a, string $current) {
                [$name, $value] = explode('=', $current);

                $a[$name] = urldecode($value);

                return $a;
            },
            [],
        );
    }
}
