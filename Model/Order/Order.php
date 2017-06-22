<?php

namespace Model\Order;

use DateTime;
use exception;

/**
 * Created by PhpStorm.
 * User: steph
 * Date: 8-6-2017
 * Time: 11:30
 */
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
    private $insertdate;

    /**
     * @var string
     */
    private $status;

    /**
     * @var float
     */
    private $shippingCosts;

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
     * @param $insertTime
     */
    public function setInsertTime($insertTime)
    {
        $this->time = $time;
    }

    /**
     * @return datetime
     */
    public function getInserttime()
    {
        return $this->insertdate;
    }

    /**
     * @param string $status
     * @return Order $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
    }

    /**
     * @return float
     */
    public function getShippingCosts()
    {
        return $this->shippingCosts;
    }
}
