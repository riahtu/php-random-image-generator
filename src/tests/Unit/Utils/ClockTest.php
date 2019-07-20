<?php

namespace Unit\Utils;

use App\Utils\Clock;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Utils\Clock
 * @covers ::__construct
 */
class ClockTest extends TestCase
{
    /**
     * @covers ::getDateTime
     * @throws \Exception
     */
    public function testIfDateTimeIsReturned(): void
    {
        $clock = new Clock();

        $dateTime = $clock->getDateTime();

        $this->assertInstanceOf(\DateTime::class, $dateTime);
    }
}