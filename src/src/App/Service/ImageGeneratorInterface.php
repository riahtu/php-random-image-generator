<?php

namespace App\Service;

interface ImageGeneratorInterface
{
    /**
     * @param resource $resource
     * @param int $width
     * @param int $height
     * @return resource
     */
    public function generateImage($resource, int $width, int $height);
}