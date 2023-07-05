<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Endpoint\Pokedex;

use App\Application\Repository\Pokedex\PokedexEntryReadRepository;
use App\Domain\Pokedex\PokedexEntryId;
use App\Infrastructure\Driven\Request\Pokedex\GetPokedexEntryRequest;
use App\Infrastructure\Driven\Response\Pokedex\GetPokedexEntryResponse;
use App\Infrastructure\Driving\Common\v1\ApiResponder\ResourceResponder;
use Symfony\Component\Routing\Annotation\Route;
use Undabot\JsonApi\Definition\Model\Request\GetResourceRequestInterface;
use Undabot\SymfonyJsonApi\Http\Model\Response\ResourceResponse;

final class GetPokedexEntryController
{
    /** @Route(path="/pokedex-entries/{id}", name="api.v1.common.pokedex-entries.get.by-entry-number", methods={"GET"}) */
    public function get(
        PokedexEntryId $id,
        PokedexEntryReadRepository $pokedexEntryReadRepository,
        GetResourceRequestInterface $request,
        ResourceResponder $responder,
    ): ResourceResponse {
        $pokedexEntry = $pokedexEntryReadRepository->get($id);

        $getPokedexEntryRequest = new GetPokedexEntryRequest($request);
        $getPokedexEntryResponse = new GetPokedexEntryResponse($pokedexEntry, $getPokedexEntryRequest);

        return $responder->resource(
            $getPokedexEntryResponse->resource(),
            $getPokedexEntryResponse->includedEntities(),
        );
    }
}
