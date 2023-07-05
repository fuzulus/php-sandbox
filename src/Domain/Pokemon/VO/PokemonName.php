<?php

declare(strict_types=1);

namespace App\Domain\Pokemon\VO;

use App\Domain\Pokemon\Exception\PokemonNameCannotBeBlankException;
use Assert\Assertion;
use Assert\AssertionFailedException;

final class PokemonName
{
    public function __construct(private readonly string $name)
    {
        try {
            Assertion::notBlank($name);
        } catch (AssertionFailedException) {
            throw new PokemonNameCannotBeBlankException();
        }
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
