<?php

declare(strict_types=1);

namespace App\Application\Repository\Pokedex;

use App\Domain\Pokedex\Exception\PokedexEntryAlreadyExistsForPokemonException;
use App\Domain\Pokedex\PokedexEntry;

interface PokedexEntryWriteRepository
{
    /** @throws PokedexEntryAlreadyExistsForPokemonException */
    public function save(PokedexEntry $pokedexEntry): void;
}
