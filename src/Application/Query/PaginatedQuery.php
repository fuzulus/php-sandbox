<?php

declare(strict_types=1);

namespace App\Application\Query;

abstract class PaginatedQuery implements Query
{
    public function __construct(
        public readonly ?int $offset,
        public readonly ?int $size
    ) {
    }
}
