<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use GuzzleHttp\Psr7\Request;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class KernelEndpointTestCase extends WebTestCase implements EndpointTestCase
{
    use EndpointTestCaseTrait;

    protected static KernelBrowser $client;

    protected static ValidatorBuilder $validatorBuilder;

    public static function setUpBeforeClass(): void
    {
        static::bootKernel();

        /** @var KernelBrowser $client */
        $client = static::getContainer()->get('test.client');
        self::$client = $client;

        self::$validatorBuilder = self::createValidatorBuilder();
    }

    protected function setUp(): void
    {
        if (null === static::$kernel) {
            static::bootKernel();
        }
    }

    public function validateEndpoint(
        Request $request,
        string $path,
        int $expectedStatusCode
    ): void {
        $this->validateRequest($request);
        $response = $this->sendRequest($request);

        $psr17Factory = new Psr17Factory();
        $psr17HttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

        $this->validateOperation($request, $path, $psr17HttpFactory->createResponse($response));

        static::assertSame($expectedStatusCode, $response->getStatusCode());
    }

    protected function validatorBuilder(): ValidatorBuilder
    {
        return self::$validatorBuilder;
    }

    protected function sendRequest(RequestInterface $request): SymfonyResponse
    {
        self::$client->request(
            $request->getMethod(),
            (string) $request->getUri(),
            $this->prepareQueryParameters($request),
            [],
            $this->prepareHeaders($request),
            (string) $request->getBody(),
        );

        return self::$client->getResponse();
    }
}
