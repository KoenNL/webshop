<?php

namespace Model\Image;

use Exception;

class Image
{

    /**
     * @var int
     */
    private $idImage;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $size;
    /**
     * @var bool
     */
    private $primary = false;
    /**
     * An array with all the sizes that are available for an image.
     * @var array
     */
    private $availableSizes = array(
        'original',
        'thumbnail',
        'medium'
    );
    /**
     * @var Image
     */
    private $originalImage;


    /**
     * @param int $idImage
     * @return Image $this
     */
    public function setIdImage($idImage)
    {
        $this->idImage = (int)$idImage;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdImage()
    {
        return $this->idImage;
    }

    /**
     * @param string $name
     * @return Image $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $path
     * @return Image $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $size
     * @return Image $this
     * @throws Exception
     */
    public function setSize($size)
    {
        if (!in_array($size, $this->availableSizes)) {
            throw new Exception('Invalid size ' . $size . ' set in ' . __METHOD__);
        }

        $this->size = $size;

        return $this;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param bool $primary
     * @return Image $this
     */
    public function setPrimary($primary)
    {
        $this->primary = (bool)$primary;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @param Image $originalImage
     * @return Image $this
     */
    public function setOriginalImage(Image $originalImage)
    {
        $this->originalImage = $originalImage;

        return $this;
    }

    /**
     * @return Image
     */
    public function getOriginalImage()
    {
        return $this->originalImage;
    }
}