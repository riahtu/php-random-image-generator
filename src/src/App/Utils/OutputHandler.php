<?php

namespace App\Utils;

class OutputHandler
{
    const BR = "\n\r";

    /** @var string $outputPrefix */
    protected string $outputPrefix;
    /** @var string $outputSuffix */
    protected string $outputSuffix;

    /**
     * @param string $outputPrefix
     * @param string $outputSuffix
     */
    public function __construct(string $outputPrefix = "", string $outputSuffix = "")
    {
        $this->outputPrefix = $outputPrefix;
        $this->outputSuffix = $outputSuffix;
    }

    /**
     * @param string $line
     */
    public function outputLine(string $line): void
    {
        echo $this->getFormattedLine(Color::White . $line) . self::BR;
    }

    /**
     * @param string $line
     */
    public function outputSuccess(string $line): void
    {
        echo $this->getFormattedLine(Color::LGreen . $line) . self::BR;
    }

    /**
     * @param string $error
     */
    public function outputError(string $error): void
    {
        echo $this->getFormattedLine(Color::Red . $error) . self::BR;
    }

    /**
     * @param string $line
     * @return string
     */
    protected function getFormattedLine(string $line): string
    {
        return $this->outputPrefix . $line . $this->outputSuffix;
    }
}