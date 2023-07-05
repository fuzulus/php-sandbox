<?php

declare(strict_types=1);

namespace App\Application\Repository\Pokemon;

use App\Domain\Pokemon\Pokemon;

interface PokemonWriteRepository
{
    public function save(Pokemon $pokemon): void;
}
