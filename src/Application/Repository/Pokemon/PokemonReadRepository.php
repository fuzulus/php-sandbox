<?php

declare(strict_types=1);

namespace App\Application\Repository\Pokemon;

use App\Domain\Pokemon\Exception\PokemonNotFoundException;
use App\Domain\Pokemon\Pokemon;
use App\Domain\Pokemon\PokemonId;

interface PokemonReadRepository
{
    public function nextId(): PokemonId;

    /** @throws PokemonNotFoundException */
    public function get(PokemonId $id): Pokemon;
}
