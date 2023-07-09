<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Pokemon;

use App\Domain\Common\VO\Clock;
use App\Domain\Pokemon\Enum\PokemonTypeEnum;
use App\Domain\Pokemon\Pokemon;
use App\Domain\Pokemon\PokemonId;
use App\Domain\Pokemon\VO\PokemonName;
use App\Domain\Pokemon\VO\PokemonType;
use App\Infrastructure\Driven\Persistence\Doctrine\Fixtures\PokemonFixture;
use App\Tests\Unit\UnitTestCase;

/**
 * @coversDefaultClass \App\Domain\Pokemon\Pokemon
 *
 * @small
 */
final class PokemonTest extends UnitTestCase
{
    public function testViewModelWillCreateValidObject(): void
    {
        $pokemon = new Pokemon(
            PokemonId::fromString(PokemonFixture::IDS[0]),
            new PokemonName('Charizard'),
            PokemonType::createFromEnum(PokemonTypeEnum::FIRE),
            PokemonType::createFromEnum(PokemonTypeEnum::DRAGON),
            new Clock((new \DateTimeImmutable())->getTimestamp()),
        );

        $viewModel = $pokemon->viewModel();

        static::assertSame((string) $pokemon->id(), $viewModel->id);
        static::assertSame((string) $pokemon->name(), $viewModel->name);
        static::assertSame($pokemon->type1()->asStringOrFail(), $viewModel->type1);
        static::assertSame($pokemon->type2()->asStringOrNull(), $viewModel->type2);
        static::assertSame($pokemon->createdAt()->asInteger(), $viewModel->createdAt);
        static::assertSame($pokemon->updatedAt()->asIntegerOrNull(), $viewModel->updatedAt);
    }
}
