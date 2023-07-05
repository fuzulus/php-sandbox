<?php

declare(strict_types=1);

namespace App\Application\Command\Pokedex;

use App\Application\Command\Command;
use App\Domain\Pokedex\PokedexEntryId;
use App\Domain\Pokedex\VO\PokedexEntryNumber;

final class UpdatePokedexEntryCommand implements Command
{
    public function __construct(
        public readonly PokedexEntryId $id,
        public readonly PokedexEntryNumber $number,
    ) {
    }
}
