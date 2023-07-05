<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Driving\Common\v1\Endpoint\Pokedex;

use App\Infrastructure\Driven\Persistence\Doctrine\Fixtures\PokedexEntryFixture;
use App\Infrastructure\Driven\Request\Pokedex\GetPokedexEntryRequest;
use App\Tests\Functional\KernelEndpointTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @coversDefaultClass \App\Infrastructure\Driving\Common\v1\Endpoint\Pokedex\GetPokedexEntryController
 *
 * @small
 */
final class GetPokedexEntryControllerTest extends KernelEndpointTestCase
{
    public function testEndpointWillReturn200(): void
    {
        $request = $this->createRequest(
            Request::METHOD_GET,
            sprintf(
                '/api/v1/common/pokedex-entries/%s?%s',
                PokedexEntryFixture::IDS[0],
                http_build_query([
                    'include' => GetPokedexEntryRequest::INCLUDE_POKEMON,
                ]),
            ),
        );

        $this->validateEndpoint(
            $request,
            '/api/v1/common/pokedex-entries/{number}',
            Response::HTTP_OK,
        );
    }
}
