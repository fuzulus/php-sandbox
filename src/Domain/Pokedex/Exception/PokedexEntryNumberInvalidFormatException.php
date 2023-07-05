<?php

declare(strict_types=1);

namespace App\Domain\Pokedex\Exception;

final class PokedexEntryNumberInvalidFormatException extends \DomainException
{
    public function __construct(string $value)
    {
        parent::__construct(
            sprintf(
                'Invalid format for Pokedex entry number %s. Valid example: #0001.',
                $value,
            ),
        );
    }
}
