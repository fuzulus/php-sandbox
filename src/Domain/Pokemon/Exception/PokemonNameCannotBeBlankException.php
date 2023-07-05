<?php

declare(strict_types=1);

namespace App\Domain\Pokemon\Exception;

final class PokemonNameCannotBeBlankException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Pokemon name cannot be blank.');
    }
}
