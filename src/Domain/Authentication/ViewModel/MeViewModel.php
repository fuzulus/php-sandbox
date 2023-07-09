<?php

declare(strict_types=1);

namespace App\Domain\Authentication\ViewModel;

final class MeViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
    ) {
    }
}
