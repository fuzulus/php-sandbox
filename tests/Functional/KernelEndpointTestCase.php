<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Application\Repository\Authentication\UserReadRepository;
use App\Domain\Authentication\VO\Email;
use App\Infrastructure\Driven\Authentication\SecurityUser;
use App\Infrastructure\Driven\Persistence\Doctrine\Fixtures\UserFixture;
use Assert\Assertion;
use GuzzleHttp\Psr7\Request;
use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class KernelEndpointTestCase extends WebTestCase implements EndpointTestCase
{
    protected static KernelBrowser $client;

    protected static ValidatorBuilder $validatorBuilder;

    protected static string $userEmail = UserFixture::EMAILS[0];

    public static function setUpBeforeClass(): void
    {
        static::bootKernel();

        /** @var KernelBrowser $client */
        $client = static::getContainer()->get('test.client');
        self::$client = $client;

        self::$validatorBuilder = self::createValidatorBuilder();
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

    protected static function createValidatorBuilder(): ValidatorBuilder
    {
        return (new ValidatorBuilder())->fromYamlFile(__DIR__ . '/../../docs/open_api.yaml');
    }

    protected function setUp(): void
    {
        if (null === static::$kernel) {
            static::bootKernel();
        }
    }

    protected function createRequest(
        string $method,
        string $path,
        ?string $body = null
    ): Request {
        if (null !== self::$userEmail) {
            $this->loginUser(self::$userEmail);
        }

        return new Request(
            $method,
            $path,
            $this->requestHeaders(),
            $body,
        );
    }

    /** @return array<string,string> */
    protected function requestHeaders(): array
    {
        return [
            'Content-Type' => 'application/vnd.api+json',
        ];
    }

    /** @param mixed[] $body */
    protected function prepareBody(array $body): string
    {
        $encodedBody = json_encode($body, JSON_THROW_ON_ERROR);
        Assertion::isJsonString($encodedBody);

        return $encodedBody;
    }

    protected function validatorBuilder(): ValidatorBuilder
    {
        return self::$validatorBuilder;
    }

    protected function validateRequest(Request $request): void
    {
        $this->validatorBuilder()->getRequestValidator()->validate($request);
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

    protected function validateOperation(Request $request, string $path, ResponseInterface $response): void
    {
        $responseValidator = $this->validatorBuilder()->getResponseValidator();

        $operation = new OperationAddress($path, mb_strtolower($request->getMethod()));
        $responseValidator->validate($operation, $response);
    }

    private function loginUser(string $email): void
    {
        /** @var UserReadRepository $userReadRepository */
        $userReadRepository = self::getContainer()->get(UserReadRepository::class);

        $user = $userReadRepository->findByEmail(new Email($email));
        $securityUser = new SecurityUser($user);

        self::$client->loginUser($securityUser, 'api');
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
