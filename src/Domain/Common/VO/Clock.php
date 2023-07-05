<?php

declare(strict_types=1);

namespace App\Domain\Common\VO;

use App\Domain\Common\Exception\TimestampLengthExceededException;
use Assert\Assertion;
use Assert\AssertionFailedException;

final class Clock
{
    public const MAX_LENGTH = 10;

    /** @throws TimestampLengthExceededException */
    public function __construct(private readonly int $timestamp)
    {
        try {
            Assertion::maxLength((string) $this->timestamp, self::MAX_LENGTH);
        } catch (AssertionFailedException) {
            throw new TimestampLengthExceededException();
        }
    }

    public function asInteger(): int
    {
        return $this->timestamp;
    }
}
