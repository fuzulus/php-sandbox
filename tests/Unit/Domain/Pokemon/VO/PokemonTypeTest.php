<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Pokemon\VO;

use App\Domain\Pokemon\Enum\PokemonTypeEnum;
use App\Domain\Pokemon\VO\PokemonType;
use App\Tests\Unit\UnitTestCase;

/**
 * @coversDefaultClass \App\Domain\Pokemon\VO\PokemonType
 *
 * @small
 */
final class PokemonTypeTest extends UnitTestCase
{
    public function testValidObjectWillBeCreatedFromPokemonTypeEnum(): void
    {
        $pokemonTypeEnum = PokemonTypeEnum::BUG;
        $pokemonType = PokemonType::createFromEnum($pokemonTypeEnum);

        static::assertSame($pokemonTypeEnum->value, $pokemonType->asStringOrFail());
        static::assertSame($pokemonTypeEnum->value, $pokemonType->asStringOrNull());
    }

    public function testValidObjectWillBeCreatedFromCreateEmpty(): void
    {
        $pokemonType = PokemonType::createEmpty();

        static::assertNull($pokemonType->asStringOrNull());

        $this->expectException(\LogicException::class);
        $pokemonType->asStringOrFail();
    }
}
