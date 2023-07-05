<?php

declare(strict_types=1);

namespace App\Infrastructure\Driving\Common\v1\Model\Pokedex;

use App\Domain\Pokedex\PokedexEntry;
use Undabot\SymfonyJsonApi\Model\ApiModel;
use Undabot\SymfonyJsonApi\Model\Resource\Annotation\Attribute;
use Undabot\SymfonyJsonApi\Service\Resource\Validation\Constraint\ResourceType;

/**
 * @ResourceType(type="pokedex-entries")
 *
 * @psalm-immutable
 */
final class PokedexEntryUpdateModel implements ApiModel
{
    public function __construct(
        public readonly string $id,
        /** @Attribute */
        public readonly string $number,
    ) {
    }

    public static function fromEntity(PokedexEntry $pokedexEntry): self
    {
        return new self(
            (string) $pokedexEntry->id(),
            (string) $pokedexEntry->number(),
        );
    }
}
