<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Driving\Common\v1\Endpoint\Pokedex;

use App\Infrastructure\Driven\Persistence\Doctrine\Fixtures\PokedexEntryFixture;
use App\Tests\Functional\KernelEndpointTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @coversDefaultClass \App\Infrastructure\Driving\Common\v1\Endpoint\Pokedex\UpdatePokedexEntryController
 *
 * @small
 */
final class UpdatePokedexEntryControllerTest extends KernelEndpointTestCase
{
    public function testEndpointWillReturn200(): void
    {
        $body = $this->prepareBody([
            'data' => [
                'id' => PokedexEntryFixture::IDS[1],
                'type' => 'pokedex-entries',
                'attributes' => [
                    'number' => '#0005',
                ],
            ],
        ]);

        $request = $this->createRequest(
            Request::METHOD_PATCH,
            sprintf(
                '/api/v1/common/pokedex-entries/%s',
                PokedexEntryFixture::IDS[1],
            ),
            $body,
        );

        $this->validateEndpoint(
            $request,
            '/api/v1/common/pokedex-entries/{id}',
            Response::HTTP_OK,
        );
    }
}
