<?php

namespace Unit\Utils;

use App\Utils\Clock;
use App\Utils\Color;
use App\Utils\OutputHandler;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Utils\OutputHandler
 * @covers \App\Utils\Color
 * @covers ::_construct
 */
class OutputHandlerTest extends TestCase
{
    /**
     * @covers ::outputLine
     * @throws \Exception
     */
    public function testIfOutputsLineWithoutFormatting(): void
    {
        $dateTime = $this->createMock(\DateTime::class);
        $dateTime
            ->expects($this->once())
            ->method('format')
            ->willReturn("10:10:10");

        $clock = $this->createMock(Clock::class);
        $clock
            ->expects($this->once())
            ->method('getDateTime')
            ->willReturn($dateTime);

        $outputHandler = new OutputHandler($clock);

        $this->expectOutputString( '10:10:10Hello' . Color::White . PHP_EOL);

        $outputHandler->outputLine("Hello");
    }

    /**
     * @covers ::outputSuccess
     * @throws \Exception
     */
    public function testIfOutputsSuccessWithoutFormatting(): void
    {
        $dateTime = $this->createMock(\DateTime::class);
        $dateTime
            ->expects($this->once())
            ->method('format')
            ->willReturn("10:10:10");

        $clock = $this->createMock(Clock::class);
        $clock
            ->expects($this->once())
            ->method('getDateTime')
            ->willReturn($dateTime);

        $ouputHandler = new OutputHandler($clock);

        $this->expectOutputString('10:10:10' . Color::LGreen . 'Hello' . Color::White . PHP_EOL);

        $ouputHandler->outputSuccess("Hello");
    }

    /**
     * @covers ::outputError
     * @throws \Exception
     */
    public function testIfOutputsErrorWithoutFormatting(): void
    {
        $dateTime = $this->createMock(\DateTime::class);
        $dateTime
            ->expects($this->once())
            ->method('format')
            ->willReturn("10:10:10");

        $clock = $this->createMock(Clock::class);
        $clock
            ->expects($this->once())
            ->method('getDateTime')
            ->willReturn($dateTime);

        $ouputHandler = new OutputHandler($clock);

        $this->expectOutputString('10:10:10' . Color::Red . 'Hello' . Color::White . PHP_EOL);

        $ouputHandler->outputError("Hello");
    }
}