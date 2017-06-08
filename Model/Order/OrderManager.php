<?php
/**
 * Created by PhpStorm.
 * User: steph
 * Date: 8-6-2017
 * Time: 13:18
 */

namespace Model\Order;


class OrderManager
{


    public function save(Order $order)
    {
        if ($order->getId()) {
            return $this->insert($order);
        }

        return $this->update($order);
    }

    public function delete(Order $order)
    {
        if ($order->getId()) {
            return $this->insert($order);
        }

        return $this->update($order);
    }
}