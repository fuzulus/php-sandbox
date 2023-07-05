<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Model\Pokedex;

use App\Domain\Pokedex\ViewModel\PokedexEntryViewModel;
use Undabot\SymfonyJsonApi\Model\ApiModel;
use Undabot\SymfonyJsonApi\Model\Resource\Annotation\Attribute;
use Undabot\SymfonyJsonApi\Model\Resource\Annotation\ToOne;
use Undabot\SymfonyJsonApi\Service\Resource\Validation\Constraint\ResourceType;

/**
 * @ResourceType(type="pokedex-entries")
 *
 * @psalm-immutable
 */
final class PokedexEntryReadModel implements ApiModel
{
    public function __construct(
        public readonly string $id,
        /** @Attribute */
        public readonly string $number,
        /** @ToOne(name="pokemon", type="pokemons") */
        public readonly string $pokemonId,
        /** @Attribute */
        public readonly int $createdAt,
        /** @Attribute */
        public readonly ?int $updatedAt,
    ) {
    }

    public static function fromViewModel(PokedexEntryViewModel $viewModel): self
    {
        return new self(
            $viewModel->id,
            $viewModel->number,
            $viewModel->pokemonId,
            $viewModel->createdAt,
            $viewModel->updatedAt,
        );
    }
}
