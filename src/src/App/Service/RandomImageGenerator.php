<?php

namespace App\Service;

class RandomImageGenerator implements ImageGeneratorInterface
{
    /**
     * @param resource $resource
     * @param int $width
     * @param int $height
     * @return resource
     * @throws \Exception
     */
    public function generateImage($resource, int $width, int $height)
    {
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $color = imagecolorallocate(
                    $resource,
                    $this->getRandColorValue(),
                    $this->getRandColorValue(),
                    $this->getRandColorValue()
                );
                imagesetpixel($resource, $x, $y, $color);
            }
        }

        return $resource;
    }

    /**
     * @return int
     * @throws \Exception
     */
    protected function getRandColorValue(): int
    {
        return random_int(0, 255);
    }
}