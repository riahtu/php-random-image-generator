<?php

namespace App\Utils;

use App\Entity\GeneratedImage;
use Symfony\Component\Filesystem\Filesystem;

class SaveHandler
{
    /** @var Filesystem $fs */
    protected FileSystem $fs;
    /** @var string $basePath */
    protected string $basePath;

    /**
     * @param Filesystem $filesystem
     * @param string $basePath
     */
    public function __construct(
        Filesystem $filesystem,
        string $basePath
    ) {
        $this->fs = $filesystem;
        $this->basePath = $basePath;

        $this->fs->mkdir($basePath);
    }

    /**
     * @param GeneratedImage $image
     */
    public function savePng(GeneratedImage $image): void
    {
        imagepng(
            $image->getResource(),
            $this->getFullPath($image->getFileName() . '.' . $image->getFileType())
        );
    }

//    /**
//     * @param GeneratedImage $image
//     */
//    public function save(GeneratedImage $image): void
//    {
//
//    }

    /**
     * @param string $fileName
     * @return string
     */
    protected function getFullPath(string $fileName): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $fileName;
    }
}