<?php

namespace App\Utils;

class OutputHandler
{
    const BR = "\n\r";

    /** @var string $outputPrefix */
    protected string $outputPrefix;
    /** @var string $outputSuffix */
    protected string $outputSuffix;
    /** @var string $timeFormat */
    protected string $timeFormat;
    /** @var string $timeSeparator */
    protected string $timeSeparator;

    /**
     * @param string $outputPrefix
     * @param string $outputSuffix
     * @param string $timeFormat
     * @param string $timeSeparator
     */
    public function __construct(
        string $outputPrefix = "",
        string $outputSuffix = "",
        string $timeFormat = "H:i:s",
        string $timeSeparator = ""
    ) {
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
        echo $this->getFormattedLine(Color::White . $line) . self::BR;
    }

    /**
     * @param string $line
     * @throws \Exception
     */
    public function outputSuccess(string $line): void
    {
        echo $this->getFormattedLine(Color::LGreen . $line) . self::BR;
    }

    /**
     * @param string $error
     * @throws \Exception
     */
    public function outputError(string $error): void
    {
        echo $this->getFormattedLine(Color::Red . $error) . self::BR;
    }

    /**
     * @param string $line
     * @return string
     * @throws \Exception
     */
    protected function getFormattedLine(string $line): string
    {
        return $this->outputPrefix . (new \DateTime())->format($this->timeFormat)
            . $this->timeSeparator . $line . $this->outputSuffix;
    }
}