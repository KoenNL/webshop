<?php

namespace Model\OrderLine;

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
     * @param int $idVariation
     * @return OrderLine $this
     */
    public function setIdVariation($idVariation)
    {
        $this->idVariation = (int)$idVariation;

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