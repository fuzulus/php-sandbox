<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Endpoint\Pokedex;

use App\Application\Bus\QueryBus;
use App\Infrastructure\Driven\Request\Pokedex\ListPokedexEntriesRequest;
use App\Infrastructure\Driven\Response\Pokedex\ListPokedexEntriesResponse;
use App\Infrastructure\Driving\Common\v1\ApiResponder\ResourceResponder;
use Symfony\Component\Routing\Annotation\Route;
use Undabot\JsonApi\Definition\Model\Request\GetResourceCollectionRequestInterface;
use Undabot\SymfonyJsonApi\Http\Model\Response\ResourceCollectionResponse;

final class ListPokedexEntriesController
{
    #[Route(path: '/pokedex-entries', name: 'api.v1.common.pokedex-entries.list', methods: 'GET')]
    public function list(
        GetResourceCollectionRequestInterface $request,
        QueryBus $queryBus,
        ResourceResponder $responder,
    ): ResourceCollectionResponse {
        $listPokedexEntriesRequest = new ListPokedexEntriesRequest($request);
        $query = $listPokedexEntriesRequest->buildQuery();

        $results = $queryBus->handleQuery($query);

        $response = new ListPokedexEntriesResponse($results);

        return $responder->resourceObjectCollection($response->resources());
    }
}
