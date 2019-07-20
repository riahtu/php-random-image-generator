<?php

namespace Unit;

use App\RandomImageProject;
use App\Service\ImageGeneratorInterface;
use App\Utils\OutputHandler;
use App\Utils\SaveHandler;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\RandomImageProject
 * @covers ::_construct
 */
class RandomImageProjectTest extends TestCase
{
    /**
     * @covers ::generate
     * @throws \Exception
     */
    public function testIfImageGetsGenerated(): void
    {
        $saveHandler = $this->createMock(SaveHandler::class);
        $saveHandler->expects($this->once())
            ->method('savePng');

        $outputHandler = $this->createMock(OutputHandler::class);
        $outputHandler->expects($this->exactly(2))
            ->method('outputLine');
        $outputHandler->expects($this->once())
            ->method('outputSuccess');

        $imageGenerator = $this->createMock(ImageGeneratorInterface::class);
        $imageGenerator->expects($this->once())
            ->method('generateImage')
            ->willReturn(null);

        $randomImageGenerator = new RandomImageProject($imageGenerator, $outputHandler, $saveHandler);
        $randomImageGenerator->generate();
    }
}