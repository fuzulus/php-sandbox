<?php

declare(strict_types=1);

namespace App\Domain\Pokedex\VO;

use App\Domain\Pokedex\Exception\PokedexEntryNumberInvalidFormatException;
use Assert\Assertion;
use Assert\AssertionFailedException;

final class PokedexEntryNumber
{
    private const FORMAT_REGEX = '/#\d{4}/';

    public function __construct(private readonly string $number)
    {
        try {
            Assertion::regex($number, self::FORMAT_REGEX);
        } catch (AssertionFailedException) {
            throw new PokedexEntryNumberInvalidFormatException($number);
        }
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
