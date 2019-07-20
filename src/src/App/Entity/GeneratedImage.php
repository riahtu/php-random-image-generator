<?php

namespace App\Entity;

class GeneratedImage
{
    /** @var string $fileName */
    protected string $fileName = "";
    /** @var string|null $fileType */
    protected string $fileType;
    /** @var resource|null $resource */
    protected $resource;

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return GeneratedImage
     */
    public function setFileName(string $fileName): GeneratedImage
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     * @return GeneratedImage
     */
    public function setFileType(string $fileType): GeneratedImage
    {
        $this->fileType = $fileType;
        return $this;
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param resource $resource
     * @return GeneratedImage
     */
    public function setResource($resource): GeneratedImage
    {
        $this->resource = $resource;
        return $this;
    }
}