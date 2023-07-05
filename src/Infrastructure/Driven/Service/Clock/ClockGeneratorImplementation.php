<?php

declare(strict_types=1);

namespace App\Infrastructure\Driven\Service\Clock;

use App\Application\Service\Clock\ClockGenerator;
use App\Domain\Common\VO\Clock;
use Carbon\CarbonImmutable;

final class ClockGeneratorImplementation implements ClockGenerator
{
    public function fromCurrentTime(): Clock
    {
        return new Clock(CarbonImmutable::now()->getTimestamp());
    }
}
