<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Driving\Common\v1\Endpoint\Pokedex;

use App\Infrastructure\Driven\Persistence\Doctrine\Fixtures\PokemonFixture;
use App\Tests\Functional\KernelEndpointTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @coversDefaultClass \App\Infrastructure\Driving\Common\v1\Endpoint\Pokedex\CreatePokedexEntryController
 *
 * @small
 */
final class CreatePokedexEntryControllerTest extends KernelEndpointTestCase
{
    public function testEndpointWillReturn201(): void
    {
        $body = $this->prepareBody([
            'data' => [
                'type' => 'pokedex-entries',
                'attributes' => [
                    'number' => '#0003',
                ],
                'relationships' => [
                    'pokemon' => [
                        'data' => [
                            'type' => 'pokemons',
                            'id' => PokemonFixture::IDS[2],
                        ],
                    ],
                ],
            ],
        ]);

        $request = $this->createRequest(
            Request::METHOD_POST,
            '/api/v1/common/pokedex-entries',
            $body,
        );

        $this->validateEndpoint(
            $request,
            '/api/v1/common/pokedex-entries',
            Response::HTTP_CREATED,
        );
    }
}
