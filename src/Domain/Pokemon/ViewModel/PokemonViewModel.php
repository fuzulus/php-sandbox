<?php

declare(strict_types=1);

namespace App\Domain\Pokemon\ViewModel;

final class PokemonViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $type1,
        public readonly ?string $type2,
        public readonly int $createdAt,
        public readonly ?int $updatedAt,
    ) {
    }
}
