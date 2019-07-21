<?php

namespace Unit\Utils;

use App\Entity\GeneratedImage;
use App\Utils\SaveHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @coversDefaultClass \App\Utils\SaveHandler
 * @covers ::_construct
 */
class SaveHandlerTest extends TestCase
{
    /** @var Filesystem $fs */
    protected FileSystem $fs;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        $this->fs = new Filesystem();
    }

    /**
     * @covers ::savePng
     */
    public function testIfSavePngWorks(): void
    {
        $imageFolder = __DIR__;
        $imageName = "testimage";
        $imagePathName = $imageFolder . DIRECTORY_SEPARATOR . "$imageName.png";

        $fileSystem = $this->createMock(Filesystem::class);
        $image = imagecreatetruecolor(200, 200);

        $saveHandler = new SaveHandler($fileSystem, $imageFolder);

        $image = (new GeneratedImage())
            ->setResource($image)
            ->setFileName($imageName)
            ->setFileType('png');

        $saveHandler->savePng($image);

        $this->assertFileExists($imagePathName);

        $this->fs->remove($imagePathName);
    }
}