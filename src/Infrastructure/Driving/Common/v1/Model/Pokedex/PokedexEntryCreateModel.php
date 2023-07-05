<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Model\Pokedex;

use Symfony\Component\Validator\Constraints as Assert;
use Undabot\SymfonyJsonApi\Model\ApiModel;
use Undabot\SymfonyJsonApi\Model\Resource\Annotation\Attribute;
use Undabot\SymfonyJsonApi\Model\Resource\Annotation\ToOne;
use Undabot\SymfonyJsonApi\Service\Resource\Validation\Constraint\ResourceType;

/**
 * @ResourceType(type="pokedex-entries")
 *
 * @psalm-immutable
 */
final class PokedexEntryCreateModel implements ApiModel
{
    public function __construct(
        public readonly string $id,
        /**
         * @Attribute
         *
         * @Assert\NotBlank
         */
        public readonly string $number,
        /**
         * @ToOne(name="pokemon", type="pokemons")
         *
         * @Assert\NotBlank
         *
         * @Assert\Uuid(versions={"4"})
         */
        public readonly string $pokemonId,
    ) {
    }
}
