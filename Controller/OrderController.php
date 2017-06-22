<?php
/**
 * Created by PhpStorm.
 * User: steph
 * Date: 21-6-2017
 * Time: 21:05
 */

namespace Controller;

use Main\Controller;
use Model\Order\OrderManager;
use Model\Translation\SystemTranslation;

class OrderController
{

    public function addProductAction($uri)
    {
        $ordermanager = new OrderManager($this->getLanguage());
        $order = $Ordermanager->getOrderByUri($uri);
        $orderline = $Ordermanager->getOrderLineByUri($uri);

        $systemTranslation = new SystemTranslation($this->getLanguage());

        if ($order) {
            $title = $order->getID() . ' ' . $order->getName();
        } else {
            $title = ucfirst($systemTranslation->translate('order-not-found'));
        }

        $values = array(
            'order' => $order,
            'title' => $title,
            'notFound' => $systemTranslation->translate('order-not-found-explanation')
        );

        $this->write($values);
    }
}