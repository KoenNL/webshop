<?php

namespace Model\Order;


use Main\Database;
use Model\Order\OrderLine;

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

        $statement = Database::query($sql);
        // Return a mutiple user
        while ($order = Database::fetchObject($statement, 'Model\\Order\\Order')) {
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

        $statement = Database::query($sql, $parameters);

        // Return a single order
        return Database::fetchObject($statement, 'Model\\Order\\Order');
    }

    private function insert(Order $order)
    {
        $sql = 'INSERT INTO `Order`(`idOrder`,`idUser`,`time`,`status`,`shippingCosts`)
                VALUES (:idOrder, :idUser, :time, :status, :shippingCosts)';
        $parameters = array(
            'idOrder' => $order->getIdOrder(),
            'idUser' => $order->getIdUser(),
            'time' => $order->getInsertTime()->format('Y-m-d H:i:s'),
            'status' => $order->getStatus(),
            'shippingCosts' => $order->getShippingCosts(),
        );

        Database::query($sql, $parameters);
        $idOrder = Database::getLastInsertId();
        if (!$idOrder) {
            return false;
        }

        $order->setIdOrder($idOrder);

        foreach ($order->getOrderLines() as $orderLine) {
            $orderLine->setIdOrder($idOrder);
            $this->saveOrderLine($orderLine);
        }

        return true;
    }


    private function update(Order $order)
    {
        $sql = 'UPDATE `Order` SET
            `idUser` = :idUser,
            `time` = :time,
            `status` = :status,
            `shippingCosts` = :shippingCosts
            WHERE `idOrder` = :idOrder';

        $parameters = array(
            'idOrder' => $order->getIdOrder(),
            'idUser' => $order->getIdUser(),
            'time' => $order->getInsertTime()->format('Y-m-d H:i:s'),
            'status' => $order->getStatus(),
            'shippingCosts' => $order->getShippingCosts());

        Database::query($sql, $parameters);

        // If the order is a shopping cart, delete and save all order lines.
        if ($order->getStatus() === 'cart') {
            $this->deleteOrderLines($order);
            foreach ($order->getOrderLines() as $orderLine) {
                $orderLine->setIdOrder($order->getIdOrder());
                $this->saveOrderLine($orderLine);
            }
        }

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

        $statement = Database::query($sql, $parameters);

        return Database::getRowCount($statement) ? true : false;
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
            'idVariation' => $orderLine->getProduct()->getSelectedVariation()->getIdVariation(),
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