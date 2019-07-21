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

    /**
     * @param ImageGeneratorInterface $generator
     * @param SaveHandler $sh
     */
    public function __construct(
        ImageGeneratorInterface $generator,
        SaveHandler $sh
    ) {
        $this->generator = $generator;
        $this->sh = $sh;

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
                        "output",
                        "O",
                        InputOption::VALUE_OPTIONAL,
                        "Output name of the image",
                        "gen_" . uniqid()
                    ),
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
                        "type",
                        "T",
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
        $fileName = $input->getOption('output');
        $fileType = $input->getOption('type');

        $output->writeln("Generating image with width $width and height $height");

        $image = imagecreatetruecolor($width, $height);

        $image = $this->generator->generateImage($image, $width, $height);

        $image = (new GeneratedImage())
            ->setFileName($fileName)
            ->setResource($image)
            ->setFileType($fileType);

        $output->writeln("Saving file as $fileName.$fileType");

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