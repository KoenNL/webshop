<?php
/**
 * Created by PhpStorm.
 * User: steph
 * Date: 8-6-2017
 * Time: 13:18
 */

namespace Model\Order;

// Save
// Delete
// GetOrderById (idorder : int)
// getOrders(idUser : int = NULL)


class OrderManager
{


    public function save(Order $order)
    {
        if ($order->getId()) {
            return $this->update($order);
        }

        return $this->insert($order);
    }

    public function delete(Order $order)
    {
        if ($order->getId()) {
            return $this->update($order);
        }

        return $this->insert($order);
    }

    public function getOrders()
    {
        $sql = 'SELECT * FROM `Order`';

        $orders = array();

        Database::query($sql);
        // Return a mutiple user
        while ($order = Database::fetchObject('Model\\Order\\Order')) {
            $orders[] = $order;
        }

        return $orders;
    }

    public function getOrdersById()
    {
        $sql = 'SELECT * FROM `Order` WHERE `idOrder` = :idOrder';

        $parameters = array(
            'idOrder' => $idOrder
        );

        Database::query($sql, $parameters);

        // Return a single order
        return Database::fetchObject('Model\\Order\\Order');
    }

    private function insert(Order $Order) {
        $sql = 'INSERT INTO `Order`(`idOrder`,`idUser`,`time`,`status`,`shippingCosts`)
                VALUES (:idOrder, :idUser, :time, :status, :shippingCosts)';
        $parameters = array(
            'idOrder' => $Order ->getIdOrder(),
            'idUser' => $Order ->getIdUser(),
            'time' => $Order ->getInserttime(),
            'status' => $Order ->getStatus(),
            'shippingCosts' => $Order ->getShippingCosts(),
        );

        Database::query($sql, $parameters);
        $idOrder = Database::getLastInsertId();
        if (!$idOrder) {
            return false;
        }
        $Order->setIdOrder($idOrder);
        return true;
    }


private function update(Order $order) {
    /** @var Update $sql */
    $sql = 'UPDATE `Order` SET
            `idOrder` = :idOrder,
            `idUser` = :idUser,
            `time` = :time,
            `status` = :status,
            `shippingCosts` = :shippingCosts,
            WHERE `idOrder` = :idOrder';
            
$parameters = array(
            'idOrder' => $Order ->getIdOrder(),
            'idUser' => $Order ->getIdUser(),
            'time' => $Order ->getInserttime(),
            'status' => $Order ->getStatus(),
            'shippingCosts' => $Order ->getShippingCosts());

            database::query($sql,$parameters);
            return true;
}
}