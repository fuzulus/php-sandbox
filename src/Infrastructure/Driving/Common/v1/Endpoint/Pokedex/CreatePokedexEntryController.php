<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Endpoint\Pokedex;

use App\Application\Bus\CommandBus;
use App\Application\Command\Pokedex\CreatePokedexEntryCommand;
use App\Application\Repository\Pokedex\PokedexEntryReadRepository;
use App\Domain\Pokedex\VO\PokedexEntryNumber;
use App\Domain\Pokemon\PokemonId;
use App\Infrastructure\Driving\Common\v1\ApiResponder\ResourceResponder;
use App\Infrastructure\Driving\Common\v1\Model\Pokedex\PokedexEntryCreateModel;
use Symfony\Component\Routing\Annotation\Route;
use Undabot\JsonApi\Definition\Model\Request\CreateResourceRequestInterface;
use Undabot\SymfonyJsonApi\Http\Model\Response\ResourceCreatedResponse;
use Undabot\SymfonyJsonApi\Http\Service\SimpleResourceHandler;

final class CreatePokedexEntryController
{
    #[Route(path: '/pokedex-entries', name: 'api.v1.common.pokedex-entries.create', methods: 'POST')]
    public function create(
        CreateResourceRequestInterface $request,
        SimpleResourceHandler $resourceHandler,
        CommandBus $commandBus,
        PokedexEntryReadRepository $pokedexEntryReadRepository,
        ResourceResponder $responder,
    ): ResourceCreatedResponse {
        /** @var \App\Infrastructure\Driving\Common\v1\Model\Pokedex\PokedexEntryCreateModel $model */
        $model = $resourceHandler->getModelFromRequest($request, PokedexEntryCreateModel::class);

        $command = new CreatePokedexEntryCommand(
            $pokedexEntryReadRepository->nextId(),
            new PokedexEntryNumber($model->number),
            PokemonId::fromString($model->pokemonId),
        );

        $commandBus->handleCommand($command);

        return $responder->resourceCreated($pokedexEntryReadRepository->get($command->id)->viewModel());
    }
}
