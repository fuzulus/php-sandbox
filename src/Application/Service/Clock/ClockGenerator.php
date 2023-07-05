<?php

declare(strict_types=1);

namespace App\Application\Service\Clock;

use App\Domain\Common\VO\Clock;

interface ClockGenerator
{
    public function fromCurrentTime(): Clock;
}
