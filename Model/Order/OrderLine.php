<?php

namespace Model\Order;

use Model\Product\Product;

class OrderLine
{

    /**
     * @var int
     */
    private $idOrderLine;

    /**
     * @var int
     */
    private $idOrder;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $tax;

    /**
     * @param int $idOrderLine
     * @return OrderLine $this
     */
    public function setIdOrderLine($idOrderLine)
    {
        $this->idOrderLine = (int)$idOrderLine;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdOrderLine()
    {
        return $this->idOrderLine;
    }

    /**
     * @param int $idOrder
     * @return OrderLine $this
     */
    public function setIdOrder($idOrder)
    {
        $this->idOrder = (int)$idOrder;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdOrder()
    {
        return $this->idOrder;
    }

    /**
     * @param Product $product
     * @return OrderLine $this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param float $amount
     * @return OrderLine $this
     */
    public function setAmount($amount)
    {
        $this->amount = floatval($amount);

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $price
     * @return OrderLine $this
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
     * @param float $tax
     * @return OrderLine $this
     */
    public function setTax($tax)
    {
        $this->tax = floatval($tax);

        return $this;
    }

    /**
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }
}