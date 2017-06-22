<?php

namespace Model\Order;

use DateTime;
use Model\OrderLine\OrderLine;

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
    private $shippingCosts;

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
     * @param float $shippingCosts
     * @return Order $this
     */
    public function setShippingCosts($shippingCosts)
    {
        $this->shippingCosts = $shippingCosts;

        return $this;
    }

    /**
     * @return float
     */
    public function getShippingCosts()
    {
        return $this->shippingCosts;
    }

    /**
     * @param OrderLine $orderLine
     * @return Order $this
     */
    public function addOrderLine(OrderLine $orderLine)
    {
        $this->orderLines[] = $orderLine;

        return $this;
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
}
