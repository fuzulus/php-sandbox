<?php

declare(strict_types=1);

namespace App\Domain\Pokedex\Exception;

use App\Domain\Pokedex\VO\PokedexEntryNumber;

final class PokedexEntryNumberTakenException extends \DomainException
{
    public function __construct(PokedexEntryNumber $entryNumber)
    {
        parent::__construct(
            sprintf(
                'Pokedex entry number %s is taken.',
                (string) $entryNumber,
            ),
        );
    }
}
