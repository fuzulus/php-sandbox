<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Common\VO;

use App\Domain\Common\Exception\TimestampLengthExceededException;
use App\Domain\Common\VO\Clock;
use App\Tests\Unit\UnitTestCase;

/**
 * @coversDefaultClass \App\Domain\Common\VO\Clock
 *
 * @small
 */
final class ClockTest extends UnitTestCase
{
    public function testValidObjectWillBeCreated(): void
    {
        $time = time();

        $clock = new Clock($time);

        static::assertSame($time, $clock->asInteger());
    }

    public function testObjectWillThrowExceptionIfMaxTimestampLengthExceeded(): void
    {
        $time = 10000000000;

        $this->expectException(TimestampLengthExceededException::class);
        new Clock($time);
    }
}
