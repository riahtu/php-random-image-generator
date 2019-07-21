<?php

namespace App\Service;

use App\Exception\UnknownColorException;

class RandomMonoImageGenerator implements ImageGeneratorInterface
{
    const AllowedColors = ["R", "G", "B"];

    /**
     * @param resource $resource
     * @param int $width
     * @param int $height
     * @param array $options
     * @return resource
     * @throws UnknownColorException
     * @throws \Exception
     */
    public function generateImage($resource, int $width, int $height, array $options = [])
    {
        $color = $options['color'];

        if (!$this->isColorValid($color)) {
            throw new UnknownColorException("Color '$color' is unknown");
        }

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                imagesetpixel(
                    $resource,
                    $x,
                    $y,
                    $this->getColorAllocation($resource, $color)
                );
            }
        }

        return $resource;
    }

    /**
     * @param $resource
     * @param string $color
     * @return int
     * @throws \Exception
     */
    public function getColorAllocation($resource, string $color): int
    {
        switch ($color) {
            case 'R':
                return imagecolorallocate($resource, $this->getRandColorValue(), 0, 0);
            case 'G':
                return imagecolorallocate($resource, 0, $this->getRandColorValue(), 0);
            case 'B':
                return imagecolorallocate($resource, 0, 0, $this->getRandColorValue());
            default:
                throw new UnknownColorException("Color $color is not a known color");
        }
    }

    /**
     * @param string|null $color
     * @return bool
     */
    protected function isColorValid(?string $color): bool
    {
        return in_array($color, self::AllowedColors);
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