<?php

namespace Model\Product;

class Product
{
    private $id;
    private $name;
    private $description;
    private $price;

    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setPrice($price)
    {
        $this->price = floatval($price);

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }
}