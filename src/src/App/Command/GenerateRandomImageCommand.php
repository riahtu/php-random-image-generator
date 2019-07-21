<?php

namespace App\Command;

use App\Entity\GeneratedImage;
use App\Exception\FileTypeNotSupportedException;
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
                    new InputOption(
                        "width",
                        "W",
                        InputOption::VALUE_OPTIONAL,
                        "Width of the image",
                        200
                    ),
                    new InputOption(
                        "height",
                        "H",
                        InputOption::VALUE_OPTIONAL,
                        "Height of the image",
                        200
                    ),
                    new InputOption(
                        "output-type",
                        "o",
                        InputOption::VALUE_OPTIONAL,
                        "Output type (png, bmp, gif)",
                        "png"
                    )
                ])
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $width = intval($input->getOption('width'));
        $height = intval($input->getOption('height'));
        $fileType = $input->getOption('output-type');

        $output->writeln("Generating image with width $width and height $height");

        $image = imagecreatetruecolor($width, $height);

        $image = $this->generator->generateImage($image, $width, $height);

        $fileName = $this->imageFilenamePrefix . uniqid();

        $image = (new GeneratedImage())
            ->setFileName($fileName)
            ->setResource($image)
            ->setFileType($fileType);

        $output->writeln("Saving file as $fileName");


        try {
            $this->sh->save($image);
        }
        catch (FileTypeNotSupportedException $exception) {
            $output->writeln("File type $fileType is not supported");
            return 1;
        }

        imagedestroy($image->getResource());

        return 0;
    }
}