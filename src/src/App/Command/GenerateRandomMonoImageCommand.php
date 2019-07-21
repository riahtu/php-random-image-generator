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

class GenerateRandomMonoImageCommand extends Command
{
    /** @var string $defaultName */
    protected static $defaultName = "img:create:mono";

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
            ->setDescription("Generate a random image with only one color")
            ->setHelp("This command allows you to create a random image with only one color")
            ->setDefinition(
                new InputDefinition([
                    new InputOption(
                        "color",
                        "C",
                        InputOption::VALUE_REQUIRED,
                        "R, G or B depending on whether you want red, green or blue. Defaults to blue.",
                        'B'
                    ),
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
        $color = strtoupper($input->getOption('color'));

        $output->writeln("Generating image with width $width and height $height and color $color");

        $image = imagecreatetruecolor($width, $height);

        $image = $this->generator->generateImage($image, $width, $height, ['color' => $color]);

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