<?php

declare(strict_types=1);

namespace App\Domain\Common;

use App\Domain\Common\VO\Clock;

trait CreateTimestampTrait
{
    private readonly Clock $createdAt;

    public function createdAt(): Clock
    {
        return $this->createdAt;
    }
}
