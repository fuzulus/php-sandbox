<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Pokedex\VO;

use App\Domain\Pokedex\Exception\PokedexEntryNumberInvalidFormatException;
use App\Domain\Pokedex\VO\PokedexEntryNumber;
use App\Tests\Unit\UnitTestCase;

/**
 * @coversDefaultClass \App\Domain\Pokedex\VO\PokedexEntryNumber
 *
 * @small
 */
final class PokedexEntryNumberTest extends UnitTestCase
{
    public function testObjectWillBeCreatedWithValidPokedexEntryNumber(): void
    {
        $value = '#0001';

        $pokedexEntryNumber = new PokedexEntryNumber($value);

        static::assertSame($value, (string) $pokedexEntryNumber);
    }

    public function testObjectWillThrowExceptionForInvalidFormat(): void
    {
        $this->expectException(PokedexEntryNumberInvalidFormatException::class);
        new PokedexEntryNumber('001');
    }
}
