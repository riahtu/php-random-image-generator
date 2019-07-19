<?php

namespace App;

use App\Utils\OutputHandler;
use App\Utils\SaveHandler;

class RandomImageGenerator
{
    /** @var OutputHandler $oh */
    protected OutputHandler $oh;
    /** @var SaveHandler $sh */
    protected SaveHandler $sh;

    /**
     * @param OutputHandler $oh
     * @param SaveHandler $sh
     */
    public function __construct(OutputHandler $oh, SaveHandler $sh)
    {
        $this->oh = $oh;
        $this->sh = $sh;
    }

    /**
     * @param int $width
     * @param int $height
     * @return void
     */
    public function generate(int $width, int $height): void
    {
        $this->oh->outputLine("Generating a random image with width $width and height $height");
    }
}