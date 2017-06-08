<?php

namespace Model\Product;

use Model\Image\Image;

class Variation
{

    /**
     * @var int
     */
    private $idVariation;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $stock;
    /**
     * @var array
     */
    private $images = array();

    /**
     * @param int $idVariation
     * @return Variation $this
     */
    public function setIdVariation($idVariation)
    {
        $this->idVariation = (int) $idVariation;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdVariation()
    {
        return $this->idVariation;
    }

    /**
     * @param float $price
     * @return Variation $this
     */
    public function setPrice($price)
    {
        $this->price = floatval($price);

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $stock
     * @return Variation $this
     */
    public function setStock($stock)
    {
        $this->stock = (int) $stock;

        return $this;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param Image $image
     * @return Variation $this
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * @param array $images
     * @return Variation $this
     */
    public function setImages(array $images)
    {
        foreach($images as $image) {
            $this->addImage($image);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

}