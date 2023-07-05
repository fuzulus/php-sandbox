<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Model\Pokemon;

use App\Domain\Pokemon\ViewModel\PokemonViewModel;
use Undabot\SymfonyJsonApi\Model\ApiModel;
use Undabot\SymfonyJsonApi\Model\Resource\Annotation\Attribute;
use Undabot\SymfonyJsonApi\Service\Resource\Validation\Constraint\ResourceType;

/**
 * @ResourceType(type="pokemons")
 *
 * @psalm-immutable
 */
final class PokemonReadModel implements ApiModel
{
    public function __construct(
        public readonly string $id,
        /** @Attribute */
        public readonly string $name,
        /** @Attribute */
        public readonly string $type1,
        /** @Attribute */
        public readonly ?string $type2,
        /** @Attribute */
        public readonly int $createdAt,
        /** @Attribute */
        public readonly ?int $updatedAt,
    ) {
    }

    public static function fromViewModel(PokemonViewModel $viewModel): self
    {
        return new self(
            $viewModel->id,
            $viewModel->name,
            $viewModel->type1,
            $viewModel->type2,
            $viewModel->createdAt,
            $viewModel->updatedAt,
        );
    }
}
