<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Common\VO;

use App\Domain\Common\VO\Clock;
use App\Domain\Common\VO\NullableClock;
use App\Tests\Unit\UnitTestCase;

/**
 * @coversDefaultClass \App\Domain\Common\VO\NullableClock
 *
 * @small
 */
final class NullableClockTest extends UnitTestCase
{
    /** @dataProvider validObjectCreationDataProvider */
    public function testValidObjectWillBeCreated(
        ?Clock $clock,
        ?int $expectedTime
    ): void {
        if (null === $clock) {
            $nullableClock = NullableClock::createEmpty();
        } else {
            $nullableClock = NullableClock::fromClock($clock);
        }

        static::assertSame($expectedTime, $nullableClock->asIntegerOrNull());
    }

    /** @return iterable<string, array{clock: ?Clock, expected: ?int}> */
    public function validObjectCreationDataProvider(): iterable
    {
        yield 'an empty object' => [
            'clock' => null,
            'expected' => null,
        ];

        $time = time();

        yield 'a Clock' => [
            'clock' => new Clock($time),
            'expected' => $time,
        ];
    }
}
