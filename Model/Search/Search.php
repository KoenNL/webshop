<?php

namespace Model\Search;

use Model\Product\Product;
use Model\User\User;

/**
 * Created by PhpStorm.
 * User: Arie Schouten
 * Date: 18-6-2017
 * Time: 22:16
 */
class Search
{
    /**
     * @var int
     */
    private $idSearch;
    /**
     * @var User
     */
    private $user;
    /**
     * @var string
     */
    private $query;
    /**
     * @var \DateTime
     */
    private $time;
    /**
     * @var array
     */
    private $products = array();

    /**
     * @param $idSearch
     * @return $this
     */
    public function setIdSearch($idSearch)
    {
    $this->idSearch =(int)$idSearch;
    return $this;
    }
    /**
     * @return int
     */
    public function getIdSearch()
    {
        return $this->idSearch;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query =(string)$query;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $time
     * @return Search
     */
    public function setTime($time)
    {
        if (is_string($time)) {
            $this->time = new DateTime($time);
        } elseif (is_object($time) && is_a($time, 'DateTime')) {
            $this->time = $time;
        } else {
            throw new Exception('Invalid value set in ' . __METHOD__);
        }

        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param Product $product
     * @return Search $this
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * @param array $products
     * @return Search $this
     */
    public function setProducts(array $products)
    {
        foreach ($products as $product) {
            $this->addProduct($product);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }
}