<?php

namespace App\Command;

use App\Entity\GeneratedImage;
use App\Service\ImageGeneratorInterface;
use App\Utils\SaveHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateRandomImageCommand extends Command
{
    /** @var string $defaultName */
    protected static $defaultName = "img:create:random";

    /** @var ImageGeneratorInterface $generator */
    protected ImageGeneratorInterface $generator;
    /** @var SaveHandler $sh */
    protected SaveHandler $sh;
    /** @var string $imageFilenamePrefix */
    protected string $imageFilenamePrefix;

    /**
     * @param ImageGeneratorInterface $generator
     * @param SaveHandler $sh
     * @param string $imageFilenamePrefix
     */
    public function __construct(
        ImageGeneratorInterface $generator,
        SaveHandler $sh,
        string $imageFilenamePrefix = "gen_"
    ) {
        $this->generator = $generator;
        $this->sh = $sh;
        $this->imageFilenamePrefix = $imageFilenamePrefix;

        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setDescription("Generate a random image with parameters")
            ->setHelp("This command allows you to create a random image")
            ->setDefinition(
                new InputDefinition([
                    new InputOption("width", "w", InputOption::VALUE_OPTIONAL),
                    new InputOption("height", "h", InputOption::VALUE_OPTIONAL),
                    new InputOption("output-location", "o", InputOption::VALUE_OPTIONAL),
                    new InputOption("output-type", "ot", InputOption::VALUE_OPTIONAL)
                ])
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $width = 200;
        $height = 200;

        $image = imagecreatetruecolor($width, $height);

        $image = $this->generator->generateImage($image, $width, $height);

        $fileName = $this->imageFilenamePrefix . uniqid();

        $image = (new GeneratedImage())
            ->setFileName($fileName)
            ->setResource($image)
            ->setFileType('png');

        $this->sh->savePng($image);
    }
}