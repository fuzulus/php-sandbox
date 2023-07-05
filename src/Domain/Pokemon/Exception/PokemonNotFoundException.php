<?php

declare(strict_types=1);

namespace App\Domain\Pokemon\Exception;

use App\Domain\Pokemon\PokemonId;

final class PokemonNotFoundException extends \DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withId(PokemonId $id): self
    {
        return new self(
            sprintf(
                'Pokemon with id %s not found.',
                (string) $id,
            ),
        );
    }
}
