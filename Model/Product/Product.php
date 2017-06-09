<?php

namespace Model\Product;

use DateTime;
use Exception;

class Product
{
    /**
     * @var int
     */
    private $idProduct;
    /**
     * @var string
     */
    private $brand;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var bool
     */
    private $combinationDiscount = false;
    /**
     * @var DateTime
     */
    private $insertDate;
    /**
     * @var string
     */
    private $uri;
    /**
     * @var bool
     */
    private $active = true;
    /**
     * Array with Variation objects.
     * @var array
     */
    private $variations = array();
    /**
     * @var int
     */
    private $langauge;

    /**
     * @param int $idProduct
     * @return Product $this
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = (int) $idProduct;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * @param string $brand
     * @return Product $this
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $name
     * @return Product $this
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
     * @return string
     * @todo nog maken!
     */
    public function getPrice()
    {
        return 'Dit is nep!!!!';
    }

    /**
     * @param string$description
     * @return Product $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param bool $combinationDiscount
     * @return Product $this
     */
    public function setCombinationDiscount($combinationDiscount)
    {
        $this->combinationDiscount = (bool) $combinationDiscount;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCombinationDiscount()
    {
        return $this->combinationDiscount;
    }

    /**
     * Set the insert date. Date can be either a ISO-8601 string or a DateTime object.
     * String will be converted to DateTime object.
     * @param mixed $insertDate
     * @return Product $this
     * @throws Exception
     */
    public function setInsertDate($insertDate)
    {
        if (is_string($insertDate)) {
            $this->insertDate = new DateTime($insertDate);
        } elseif (is_object($insertDate) && is_a($insertDate, 'DateTime')) {
            $this->insertDate = $insertDate;
        } else {
            throw new Exception('Invalid value set in ' . __METHOD__);
        }

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getInsertDate()
    {
        return $this->insertDate;
    }

    /**
     * @param string $uri
     * @return Product $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param bool $active
     * @return Product $this
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param Variation $variation
     * @return Product $this
     */
    public function addVariation(Variation $variation)
    {
        $this->variations[] = $variation;

        return $this;
    }

    /**
     * @param array $variations
     * @return Product $this
     */
    public function setVariations(array $variations)
    {
        foreach ($variations as $variation) {
            $this->addVariation($variation);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getVariations()
    {
        return $this->variations;
    }

    /**
     * @param int $language
     * @return Product $this
     */
    public function setLanguage($language)
    {
        $this->langauge = (int) $language;

        return $this;
    }

    /**
     * @return int
     */
    public function getLanguage()
    {
        return $this->langauge;
    }
}