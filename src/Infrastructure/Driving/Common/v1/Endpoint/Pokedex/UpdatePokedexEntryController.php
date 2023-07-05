<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Endpoint\Pokedex;

use App\Application\Bus\CommandBus;
use App\Application\Command\Pokedex\UpdatePokedexEntryCommand;
use App\Application\Repository\Pokedex\PokedexEntryReadRepository;
use App\Domain\Pokedex\PokedexEntryId;
use App\Domain\Pokedex\VO\PokedexEntryNumber;
use App\Infrastructure\Driving\Common\v1\ApiResponder\ResourceResponder;
use App\Infrastructure\Driving\Common\v1\Model\Pokedex\PokedexEntryUpdateModel;
use Symfony\Component\Routing\Annotation\Route;
use Undabot\JsonApi\Definition\Model\Request\UpdateResourceRequestInterface;
use Undabot\SymfonyJsonApi\Http\Model\Response\ResourceUpdatedResponse;
use Undabot\SymfonyJsonApi\Http\Service\SimpleResourceHandler;
use Undabot\SymfonyJsonApi\Model\Resource\CombinedResource;
use Undabot\SymfonyJsonApi\Service\Resource\Factory\ResourceFactory;

final class UpdatePokedexEntryController
{
    #[Route(path: '/pokedex-entries/{id}', name: 'api.v1.common.pokedex-entries.update', methods: 'PATCH')]
    public function update(
        PokedexEntryId $id,
        PokedexEntryReadRepository $pokedexEntryReadRepository,
        ResourceFactory $resourceFactory,
        UpdateResourceRequestInterface $request,
        SimpleResourceHandler $resourceHandler,
        CommandBus $commandBus,
        ResourceResponder $responder,
    ): ResourceUpdatedResponse {
        $pokedexEntry = $pokedexEntryReadRepository->get($id);

        $baseModel = PokedexEntryUpdateModel::fromEntity($pokedexEntry);
        $baseResource = $resourceFactory->make($baseModel);
        $updateResource = new CombinedResource($baseResource, $request->getResource());

        /** @var PokedexEntryUpdateModel $model */
        $model = $resourceHandler->getModelFromResource($updateResource, PokedexEntryUpdateModel::class);

        $command = new UpdatePokedexEntryCommand(
            $id,
            new PokedexEntryNumber($model->number),
        );

        $commandBus->handleCommand($command);

        return $responder->resourceUpdated($pokedexEntryReadRepository->get($id)->viewModel());
    }
}
