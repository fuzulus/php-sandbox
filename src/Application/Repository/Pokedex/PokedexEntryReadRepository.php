<?php

declare(strict_types=1);

namespace App\Application\Repository\Pokedex;

use App\Domain\Pokedex\Exception\PokedexEntryNotFoundException;
use App\Domain\Pokedex\PokedexEntry;
use App\Domain\Pokedex\PokedexEntryId;
use App\Domain\Pokedex\VO\PokedexEntryNumber;

interface PokedexEntryReadRepository
{
    public function nextId(): PokedexEntryId;

    /** @throws PokedexEntryNotFoundException */
    public function get(PokedexEntryId $id): PokedexEntry;

    public function findByEntryNumber(PokedexEntryNumber $number): ?PokedexEntry;
}
