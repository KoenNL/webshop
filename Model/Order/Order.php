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
     * Set the insert date. Date can be either a ISO-8601 string or a DateTime object.
     * String will be converted to DateTime object.
     * @param mixed $insertDate
     * @return Order $this
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
     * @return datetime
     */
    public function getInsertdate()
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
