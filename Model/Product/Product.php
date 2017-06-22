<?php

namespace Model\Product;

use DateTime;
use Exception;
use Model\Category\Category;
use Model\Image\Image;
use Model\Translation\Translation;

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
     * @var Translation
     */
    private $name;
    /**
     * @var Translation
     */
    private $description;
    /**
     * @var float
     */
    private $price;
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
     * @var array
     */
    private $categories = array();
    /**
     * @var array
     */
    private $images = array();
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
     * @param Translation $name
     * @return Product $this
     */
    public function setName(Translation $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Translation
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Translation $description
     * @return Product $this
     */
    public function setDescription(Translation $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Translation
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param float $price
     * @return Product $this
     */
    public function setPrice($price)
    {
        $this->price = floatval($price);

        return $this;
    }

    /**
     * Set the price of this Product by finding the dominant price in it's variations.
     * @return bool True if a dominant price is found, false if not.
     */
    private function setPriceFromVariations()
    {
        $prices = array();
        foreach ($this->variations as $variation) {
            $prices[] = (string) $variation->getPrice();
        }

        if ($prices) {
            $counter= array_flip(array_count_values($prices));
            sort($counter);
            $this->setPrice(array_pop($counter));
            return true;
        }

        return false;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        if (!$this->price && $this->variations) {
            $this->setPriceFromVariations();
        }
        return $this->price;
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
     * @param Category $category
     * @return Product $this
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * @param array $categories
     * @return Product $this
     */
    public function setCategories(array $categories)
    {
        foreach ($categories as $category) {
            $this->addCategory($category);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Check if the given category is linked to this product.
     * @param Category $category
     * @return bool
     */
    public function hasCategory(Category $category)
    {
        foreach ($this->categories as $savedCategory) {
            if ($category === $savedCategory) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Image $image
     * @return Product $this
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * @param array $images
     * @return Product $this
     */
    public function setImages(array $images)
    {
        foreach ($images as $image) {
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

    /**
     * @return Image|null
     */
    public function getPrimaryImage()
    {
        foreach ($this->images as $image) {
            if ($image->getPrimary()) {
                return $image;
            }
        }

        return null;
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