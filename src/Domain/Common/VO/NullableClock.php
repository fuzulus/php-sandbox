<?php

declare(strict_types=1);

namespace App\Domain\Common\VO;

final class NullableClock
{
    private function __construct(private readonly ?int $timestamp)
    {
    }

    public static function createEmpty(): self
    {
        return new self(null);
    }

    public static function fromClock(Clock $clock): self
    {
        return new self($clock->asInteger());
    }

    public function asIntegerOrNull(): ?int
    {
        return $this->timestamp;
    }
}
