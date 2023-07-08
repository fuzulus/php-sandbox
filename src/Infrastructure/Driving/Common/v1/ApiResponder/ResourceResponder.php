<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\ApiResponder;

use App\Domain\Authentication\ViewModel\MeViewModel;
use App\Domain\Pokedex\ViewModel\PokedexEntryListViewModel;
use App\Domain\Pokedex\ViewModel\PokedexEntryViewModel;
use App\Domain\Pokemon\ViewModel\PokemonViewModel;
use App\Infrastructure\Driving\Common\v1\Model\Pokedex\PokedexEntryListModel;
use App\Infrastructure\Driving\Common\v1\Model\Pokedex\PokedexEntryReadModel;
use App\Infrastructure\Driving\Common\v1\Model\Pokemon\PokemonReadModel;
use App\Infrastructure\Driving\Common\v1\Model\User\MeReadModel;
use Undabot\SymfonyJsonApi\Http\Service\Responder\AbstractResponder;

final class ResourceResponder extends AbstractResponder
{
    /** {@inheritdoc} */
    protected function getMap(): array
    {
        return [
            PokedexEntryViewModel::class => [PokedexEntryReadModel::class, 'fromViewModel'],
            PokedexEntryListViewModel::class => [PokedexEntryListModel::class, 'fromViewModel'],
            PokemonViewModel::class => [PokemonReadModel::class, 'fromViewModel'],
            MeViewModel::class => [MeReadModel::class, 'fromViewModel'],
        ];
    }
}
