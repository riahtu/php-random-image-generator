<?php

namespace App\Utils;

use App\Entity\GeneratedImage;
use App\Exception\FileTypeNotSupportedException;
use Nette\NotImplementedException;
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
            $this->getFullPath($image->getFileName() . '.png')
        );
    }

    /**
     * @param GeneratedImage $image
     */
    public function saveGif(GeneratedImage $image): void
    {
        imagegif(
            $image->getResource(),
            $this->getFullPath($image->getFileName() . '.gif')
        );
    }

    /**
     * @param GeneratedImage $image
     */
    public function saveBmp(GeneratedImage $image): void
    {
        imagebmp(
            $image->getResource(),
            $this->getFullPath($image->getFileName() . '.bmp')
        );
    }

    /**
     * @param GeneratedImage $image
     * @throws FileTypeNotSupportedException
     */
    public function save(GeneratedImage $image): void
    {
        switch ($image->getFileType()) {
            case 'png':
                $this->savePng($image);
                break;
            case 'gif':
                $this->saveGif($image);
                break;
            case 'bmp':
                $this->saveBmp($image);
                break;
            default:
                throw new FileTypeNotSupportedException("Filetype " . $image->getFileType() . ' not supported!');
        }
    }

    /**
     * @param string $fileName
     * @return string
     */
    protected function getFullPath(string $fileName): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $fileName;
    }
}