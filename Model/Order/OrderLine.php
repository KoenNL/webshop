<?php

namespace Model\OrderLine;

/**
 * Created by PhpStorm.
 * User: steph
 * Date: 8-6-2017
 * Time: 11:31
 */
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
     * @var int
     */
    private $idVariation;

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
        $this->idOrderLine = $idOrderLine;
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
        $this->idOrder = $idOrder;
    }

    /**
     * @return int
     */
    public function getIdOrder()
    {
        return $this->idOrder;
    }

    /**
     * @param int $idVariation
     * @return OrderLine $this
     */
    public function setIdVariation($idVariation)
    {
        $this->idVariation = $idVariation;
    }

    /**
     * @return int
     */
    public function getIdVariation()
    {
        return $this->idVariation;
    }

    /**
     * @param float $amount
     * @return OrderLine $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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
        $this->price = $price;
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
        $this->tax = $tax;
    }

    /**
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }
}