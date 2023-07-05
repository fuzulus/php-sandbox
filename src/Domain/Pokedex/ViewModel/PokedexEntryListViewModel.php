<?php

declare(strict_types=1);

namespace App\Domain\Pokedex\ViewModel;

final class PokedexEntryListViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $number,
        public readonly string $pokemonName,
        public readonly string $pokemonType1,
        public readonly ?string $pokemonType2,
        public readonly int $createdAt,
        public readonly ?int $updatedAt,
    ) {
    }
}
