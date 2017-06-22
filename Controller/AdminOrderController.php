<?php
/**
 * Created by PhpStorm.
 * User: steph
 * Date: 22-6-2017
 * Time: 11:13
 */

namespace Controller;

use Model\Order\Order;
use Model\OrderLine\Orderline;
use Model\Order\OrderManager;
use Model\Translation\SystemTranslation;

class AdminOrderController extends AdminOrderController
{

    public function orderListAction()
    {
        $this->template->setTemplate('admin');

        $orderManager = new OrderManager($this->getLanguage());

        if (!empty($_POST['search'])) {
            $orders = OrderManager::->getOrdersByName($_POST['search']);
        } else {
            $orders = $orderManager->getOrders();
        }

        $systemTranslation = new SystemTranslation($this->getLanguage());

        $this->template->setTitle(ucfirst($systemTranslation->translate('order-list')));
        $this->template->addBreadcrumb('adminorder/orderlist', ucfirst($systemTranslation->translate('order-list')));

        $values = array(
            'orders' => $orders,
            'noResults' => $systemTranslation->translate('no-results'),
            'search' => $systemTranslation->translate('search'),
            'newOrder' => $systemTranslation->translate('new-order'),
        );

        $this->write($values);
    }

    public function orderAction($idOrder = null)
    {
        $orderManager = new OrderManager($this->getLanguage());

        $systemTranslation = new SystemTranslation($this->getLanguage());

        if ($idOrder) {
            $order = $orderManager->getOrderById($idOrder);
            $this->template->setTitle($product->getBrand() . ' ' . $order->getName());
        } else {
            $order = new Order();
            $this->template->setTitle(ucfirst($systemTranslation->translate('new-order')));
        }

        if (!empty($_POST['save'])) {
            $order->setIdOrder($_POST['id'])
                ->setNameOrder($_POST['name']);

            $orderManager->save($order);
        }

        $values = array(
            'order' => $order,
            'save' => $systemTranslation->translate('save')
        );

        $this->write($values);
    }

}
?>