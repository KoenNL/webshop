<?php

namespace Model\Order;

// Save
// Delete
// GetOrderById (idorder : int)
// getOrders(idUser : int = NULL)


use Main\Database;
use Model\OrderLine\OrderLine;

class OrderManager
{


    public function save(Order $order)
    {
        if ($order->getIdOrder()) {
            return $this->update($order);
        }

        return $this->insert($order);
    }

    public function delete(Order $order)
    {

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

    public function getOrderById($idOrder)
    {
        $sql = 'SELECT * FROM `Order` WHERE `idOrder` = :idOrder';

        $parameters = array(
            'idOrder' => $idOrder
        );

        Database::query($sql, $parameters);

        // Return a single order
        return Database::fetchObject('Model\\Order\\Order');
    }

    private function insert(Order $Order)
    {
        $sql = 'INSERT INTO `Order`(`idOrder`,`idUser`,`time`,`status`,`shippingCosts`)
                VALUES (:idOrder, :idUser, :time, :status, :shippingCosts)';
        $parameters = array(
            'idOrder' => $Order->getIdOrder(),
            'idUser' => $Order->getIdUser(),
            'time' => $Order->getInserttime(),
            'status' => $Order->getStatus(),
            'shippingCosts' => $Order->getShippingCosts(),
        );

        Database::query($sql, $parameters);
        $idOrder = Database::getLastInsertId();
        if (!$idOrder) {
            return false;
        }
        $Order->setIdOrder($idOrder);
        return true;
    }


    private function update(Order $order)
    {
        /** @var Update $sql */
        $sql = 'UPDATE `Order` SET
            `idOrder` = :idOrder,
            `idUser` = :idUser,
            `time` = :time,
            `status` = :status,
            `shippingCosts` = :shippingCosts,
            WHERE `idOrder` = :idOrder';

        $parameters = array(
            'idOrder' => $Order->getIdOrder(),
            'idUser' => $Order->getIdUser(),
            'time' => $Order->getInserttime(),
            'status' => $Order->getStatus(),
            'shippingCosts' => $Order->getShippingCosts());

        database::query($sql, $parameters);
        return true;
    }

    /**
     * Delete all order lines from the given order. Order lines will only be deleted if the status of the order is "cart".
     * @param Order $order
     * @return bool True on success or false on failure.
     */
    private function deleteOrderLines(Order $order)
    {
        if ($order->getStatus() !== 'cart') {
            return false;
        }

        $sql = 'DELETE FROM `OrderLine` WHERE `idOrder` = :idOrder';

        $parameters = array(
            'idOrder' => $order->getIdOrder()
        );

        return Database::query($sql, $parameters);
    }

    /**
     * Save a new OrderLine to the database.
     * @param OrderLine $orderLine
     * @return bool True on success or false on failure.
     */
    private function saveOrderLine(OrderLine $orderLine)
    {
        $sql = 'INSERT INTO `OrderLine` (`idOrder`, `idVariation`, `amount`, `price`, `tax`)
          VALUES(:idOrder, :idVariation, :amount, :price, :tax)';

        $parameters = array(
            'idOrder' => $orderLine->getIdOrder(),
            'idVariation' => $orderLine->getIdVariation(),
            'amount' => $orderLine->getAmount(),
            'price' => $orderLine->getPrice(),
            'tax' => $orderLine->getTax()
        );

        Database::query($sql, $parameters);

        $idOrderLine = Database::getLastInsertId();

        if (!$idOrderLine) {
            return false;
        }

        $orderLine->setIdOrderLine($idOrderLine);

        return true;
    }
}