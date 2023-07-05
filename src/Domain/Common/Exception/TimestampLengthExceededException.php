<?php

declare(strict_types=1);

namespace App\Domain\Common\Exception;

use App\Domain\Common\VO\Clock;

final class TimestampLengthExceededException extends \DomainException
{
    public function __construct()
    {
        parent::__construct(
            sprintf(
                'Max timestamp length of %d exceeded.',
                Clock::MAX_LENGTH,
            ),
        );
    }
}
