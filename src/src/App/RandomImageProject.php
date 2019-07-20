<?php

namespace App;

use App\Entity\GeneratedImage;
use App\Service\ImageGeneratorInterface;
use App\Utils\OutputHandler;
use App\Utils\SaveHandler;

class RandomImageProject
{
    /** @var ImageGeneratorInterface $generator */
    protected ImageGeneratorInterface $generator;
    /** @var OutputHandler $oh */
    protected OutputHandler $oh;
    /** @var SaveHandler $sh */
    protected SaveHandler $sh;
    /** @var string $imageFilenamePrefix */
    protected string $imageFilenamePrefix;

    /**
     * @param ImageGeneratorInterface $generator
     * @param OutputHandler $oh
     * @param SaveHandler $sh
     * @param string $imageFilenamePrefix
     */
    public function __construct(
        ImageGeneratorInterface $generator,
        OutputHandler $oh,
        SaveHandler $sh,
        string $imageFilenamePrefix = "gen_"
    ) {
        $this->generator = $generator;
        $this->oh = $oh;
        $this->sh = $sh;
        $this->imageFilenamePrefix = $imageFilenamePrefix;
    }

    /**
     * @param int $width
     * @param int $height
     * @return void
     * @throws \Exception
     */
    public function generate(int $width = 200, int $height = 200): void
    {
        $this->oh->outputLine("Generating a random image with width $width and height $height");

        $image = imagecreatetruecolor($width, $height);

        $image = $this->generator->generateImage($image, $width, $height);

        $fileName = $this->imageFilenamePrefix . uniqid();

        $this->oh->outputLine("Saving image with name $fileName");

        $image = (new GeneratedImage())
            ->setFileName($fileName)
            ->setResource($image)
            ->setFileType('png');

        $this->sh->savePng($image);

        $this->oh->outputSuccess("Done! Saved image '$fileName' with width $width and height $height :)");
    }
}