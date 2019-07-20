<?php

namespace App\Utils;

class OutputHandler
{
    /** @var Clock $clock */
    protected Clock $clock;
    /** @var string $outputPrefix */
    protected string $outputPrefix;
    /** @var string $outputSuffix */
    protected string $outputSuffix;
    /** @var string $timeFormat */
    protected string $timeFormat;
    /** @var string $timeSeparator */
    protected string $timeSeparator;

    /**
     * @param Clock $clock
     * @param string $outputPrefix
     * @param string $outputSuffix
     * @param string $timeFormat
     * @param string $timeSeparator
     */
    public function __construct(
        Clock $clock,
        string $outputPrefix = "",
        string $outputSuffix = "",
        string $timeFormat = "H:i:s",
        string $timeSeparator = ""
    ) {
        $this->clock = $clock;
        $this->outputPrefix = $outputPrefix;
        $this->outputSuffix = $outputSuffix;
        $this->timeFormat = $timeFormat;
        $this->timeSeparator = $timeSeparator;
    }

    /**
     * @param string $line
     * @throws \Exception
     */
    public function outputLine(string $line): void
    {
        echo $this->getFormattedLine($line) . PHP_EOL;
    }

    /**
     * @param string $line
     * @throws \Exception
     */
    public function outputSuccess(string $line): void
    {
        echo $this->getFormattedLine(Color::LGreen . $line) . PHP_EOL;
    }

    /**
     * @param string $error
     * @throws \Exception
     */
    public function outputError(string $error): void
    {
        echo $this->getFormattedLine(Color::Red . $error) . PHP_EOL;
    }

    /**
     * @param string $line
     * @return string
     * @throws \Exception
     */
    protected function getFormattedLine(string $line): string
    {
        return $this->outputPrefix . $this->clock->getDateTime()->format($this->timeFormat)
            . $this->timeSeparator . $line . $this->outputSuffix . Color::White;
    }
}