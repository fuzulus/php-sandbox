<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Response\Pokedex;

use App\Domain\Pokedex\PokedexEntry;
use App\Domain\Pokedex\ViewModel\PokedexEntryViewModel;
use App\Infrastructure\Driven\Request\Pokedex\GetPokedexEntryRequest;
use Undabot\SymfonyJsonApi\Model\Collection\ObjectCollection;
use Undabot\SymfonyJsonApi\Model\Collection\UniqueCollection;

final class GetPokedexEntryResponse
{
    private readonly ObjectCollection $includedEntities;

    public function __construct(
        private readonly PokedexEntry $pokedexEntry,
        GetPokedexEntryRequest $request,
    ) {
        $this->includedEntities = new UniqueCollection();

        if ($request->includesPokemon()) {
            $this->includedEntities->addObject($this->pokedexEntry->pokemon()->viewModel());
        }
    }

    public function resource(): PokedexEntryViewModel
    {
        return $this->pokedexEntry->viewModel();
    }

    /** @return object[] */
    public function includedEntities(): array
    {
        return $this->includedEntities->getItems();
    }
}
