<?php

declare(strict_types=1);

namespace App\Application\Query\PokedexEntry;

use App\Application\Query\PaginatedQuery;

final class PokedexEntryQuery extends PaginatedQuery
{
    public function __construct(
        ?int $offset,
        ?int $size,
        public readonly ?string $number,
    ) {
        parent::__construct($offset, $size);
    }
}
