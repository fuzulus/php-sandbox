<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Model\Pokedex;

use App\Domain\Pokedex\ViewModel\PokedexEntryListViewModel;
use Undabot\SymfonyJsonApi\Model\ApiModel;
use Undabot\SymfonyJsonApi\Model\Resource\Annotation\Attribute;
use Undabot\SymfonyJsonApi\Service\Resource\Validation\Constraint\ResourceType;

/**
 * @ResourceType(type="pokedex-entries")
 *
 * @psalm-immutable
 */
final class PokedexEntryListModel implements ApiModel
{
    public function __construct(
        public readonly string $id,
        /** @Attribute */
        public readonly string $number,
        /** @Attribute */
        public readonly string $pokemonName,
        /** @Attribute */
        public readonly string $pokemonType1,
        /** @Attribute */
        public readonly ?string $pokemonType2,
        /** @Attribute */
        public readonly int $createdAt,
        /** @Attribute */
        public readonly ?int $updatedAt,
    ) {
    }

    public static function fromViewModel(PokedexEntryListViewModel $viewModel): self
    {
        return new self(
            $viewModel->id,
            $viewModel->number,
            $viewModel->pokemonName,
            $viewModel->pokemonType1,
            $viewModel->pokemonType2,
            $viewModel->createdAt,
            $viewModel->updatedAt,
        );
    }
}
