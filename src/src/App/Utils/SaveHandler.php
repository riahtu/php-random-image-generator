<?php

namespace App\Utils;

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
     * @param $image
     * @param string $fileName
     */
    public function savePng($image, string $fileName)
    {
        imagepng($image, $this->basePath . "/$fileName.png");
    }
}