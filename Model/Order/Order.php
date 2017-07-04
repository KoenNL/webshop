<?php

namespace Model\Order;

use DateTime;

class Order
{
    /**
     * @var int
     */
    private $idOrder;

    /**
     * @var int
     */
    private $idUser;

    /**
     * @var datetime
     */
    private $insertTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $shippingCosts;

    /**
     * @var float
     */
    private $shippingCostsThreshold;

    /**
     * @var array
     */
    private $orderLines = array();

    /**
     * @param int $idOrder
     * @return Order $this
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
     * @param int $idUser
     * @return Order $this
     */
    public function setIdUser($idUser)
    {
        $this->idUser = (int)$idUser;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param DateTime $insertTime
     * @return Order
     */
    public function setInsertTime(DateTime $insertTime)
    {
        $this->insertTime = $insertTime;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getInsertTime()
    {
        return $this->insertTime;
    }

    /**
     * @param string $status
     * @return Order $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param float $price
     * @return Order $this
     */
    public function setPrice($price)
    {
        $this->price = floatval($price);

        return $this;
    }

    /**
     * @return Order $this
     */
    public function setPriceFromOrderLines()
    {
        $this->price = 0;
        foreach ($this->orderLines as $orderLine) {
            $this->price += ($orderLine->getPrice() * $orderLine->getAmount());
        }

        return $this;
    }

    /**
     * Get the total price of the order. Will return the set price or calculate it by the order lines.
     * @param boolean $fromOrderLines Set to true if price needs to be calculated, or false if not. Default true.
     * @return float
     */
    public function getPrice($fromOrderLines = true)
    {
        if ($fromOrderLines) {
            $this->setPriceFromOrderLines();
        }

        return $this->price;
    }

    /**
     * @param float $shippingCosts
     * @return Order $this
     */
    public function setShippingCosts($shippingCosts)
    {
        $this->shippingCosts = $shippingCosts;

        return $this;
    }

    /**
     * @param bool $calculate
     * @return float
     */
    public function getShippingCosts($calculate = true)
    {
        if ($calculate && $this->getPrice() >= $this->shippingCostsThreshold) {
            return 0;
        }
        return $this->shippingCosts;
    }

    /**
     * @param float $shippingCostsThreshold
     * @return Order $this
     */
    public function setShippingCostsThreshold($shippingCostsThreshold)
    {
        $this->shippingCostsThreshold = floatval($shippingCostsThreshold);

        return $this;
    }

    /**
     * @return float
     */
    public function getShippingCostsThreshold()
    {
        return $this->shippingCostsThreshold;
    }

    /**
     * @param OrderLine $orderLine
     * @return Order $this
     */
    public function addOrderLine(OrderLine $orderLine)
    {
        $existingOrderLineKey = $this->checkIfOrderLineExists($orderLine);
        if ($existingOrderLineKey !== false) {
            $this->orderLines[$existingOrderLineKey]->setAmount($this->orderLines[$existingOrderLineKey]->getAmount() + $orderLine->getAmount());
        } else {
            $this->orderLines[] = $orderLine;
        }

        return $this;
    }

    /**
     * @param OrderLine $orderLine
     * @return bool True on success or false on failure.
     */
    public function removeOrderLine(OrderLine $orderLine)
    {
        $key = $this->checkIfOrderLineExists($orderLine);

        if ($key !== false) {
            unset($this->orderLines[$key]);
            return true;
        }

        return false;
    }

    /**
     * Check if the given OrderLine already exists in this Order.
     * @param OrderLine $orderLine
     * @return bool|int Returns the array key of the OrderLine if found, or false if not.
     */
    public function checkIfOrderLineExists(OrderLine $orderLine)
    {
        foreach ($this->orderLines as $key => $existingOrderLine) {
            if ($orderLine->getProduct()->getSelectedVariation()->getIdVariation() === $existingOrderLine->getProduct()->getSelectedVariation()->getIdVariation()) {
                return $key;
            }
        }
        return false;
    }

    /**
     * @param array $orderLines
     * @return Order $this
     */
    public function setOrderLines(array $orderLines)
    {
        foreach ($orderLines as $orderLine) {
            $this->addOrderLine($orderLine);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }
}
