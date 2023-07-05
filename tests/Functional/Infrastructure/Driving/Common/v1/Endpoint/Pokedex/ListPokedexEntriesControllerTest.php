<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Driving\Common\v1\Endpoint\Pokedex;

use App\Tests\Functional\KernelEndpointTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @coversDefaultClass \App\Infrastructure\Driving\Common\v1\Endpoint\Pokedex\ListPokedexEntriesController
 *
 * @small
 */
final class ListPokedexEntriesControllerTest extends KernelEndpointTestCase
{
    public function testEndpointWillReturn200(): void
    {
        $request = $this->createRequest(
            Request::METHOD_GET,
            '/api/v1/common/pokedex-entries',
        );

        $this->validateEndpoint(
            $request,
            '/api/v1/common/pokedex-entries',
            Response::HTTP_OK,
        );
    }
}
