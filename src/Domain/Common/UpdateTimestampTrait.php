<?php

declare(strict_types=1);

namespace App\Domain\Common;

use App\Domain\Common\VO\NullableClock;

trait UpdateTimestampTrait
{
    private NullableClock $updatedAt;

    public function updatedAt(): NullableClock
    {
        return $this->updatedAt;
    }
}
