<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Pokemon\VO;

use App\Domain\Pokemon\Exception\PokemonNameCannotBeBlankException;
use App\Domain\Pokemon\VO\PokemonName;
use App\Tests\Unit\UnitTestCase;

/**
 * @coversDefaultClass \App\Domain\Pokemon\VO\PokemonName
 *
 * @small
 */
final class PokemonNameTest extends UnitTestCase
{
    public function testObjectWillBeCreatedWithValidPokemonName(): void
    {
        $value = 'Charizard';

        $pokemonName = new PokemonName($value);

        static::assertSame($value, (string) $pokemonName);
    }

    public function testObjectWillThrowExceptionForBlankName(): void
    {
        $this->expectException(PokemonNameCannotBeBlankException::class);
        new PokemonName('');
    }
}
