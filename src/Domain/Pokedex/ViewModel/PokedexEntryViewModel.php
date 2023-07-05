<?php

declare(strict_types=1);

namespace App\Domain\Pokedex\ViewModel;

final class PokedexEntryViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $number,
        public readonly string $pokemonId,
        public readonly int $createdAt,
        public readonly ?int $updatedAt,
    ) {
    }
}
