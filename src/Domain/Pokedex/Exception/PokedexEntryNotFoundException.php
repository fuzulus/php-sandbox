<?php

declare(strict_types=1);

namespace App\Domain\Pokedex\Exception;

use App\Domain\Pokedex\PokedexEntryId;
use App\Domain\Pokedex\VO\PokedexEntryNumber;

final class PokedexEntryNotFoundException extends \DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withId(PokedexEntryId $id): self
    {
        return new self(
            sprintf(
                'Pokedex entry with id %s not found.',
                (string) $id,
            ),
        );
    }

    public static function withEntryNumber(PokedexEntryNumber $entryNumber): self
    {
        return new self(
            sprintf(
                'Pokedex entry with number %s not found.',
                (string) $entryNumber,
            ),
        );
    }
}
