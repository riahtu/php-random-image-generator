<?php

namespace Unit\Entity;

use App\Entity\GeneratedImage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Entity\GeneratedImage
 * @covers ::_construct
 */
class GeneratedImageTest extends TestCase
{
    /**
     * @covers ::getFileName
     * @covers ::setFileName
     */
    public function testFilenameGetAndSetter(): void
    {
        $gImage = new GeneratedImage();
        $fileName = "testImage.png";

        $gImage->setFileName($fileName);

        $this->assertEquals($fileName, $gImage->getFileName());
    }

    /**
     * @covers ::getResource
     * @covers ::setResource
     */
    public function testResourceGetAndSetter(): void
    {
        $gImage = new GeneratedImage();
        $resource = imagecreate(100, 100);

        $gImage->setResource($resource);

        $this->assertEquals($resource, $gImage->getResource());
    }
}