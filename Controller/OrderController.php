<?php

namespace Controller;

use Main\Controller;
use Model\Order\Order;
use Model\Order\OrderManager;
use Model\OrderLine\OrderLine;
use Model\Product\ProductManager;
use Model\Translation\SystemTranslation;
use \DateTime;

class OrderController extends Controller
{

    public function addProductAction($idVariation = null)
    {
        $systemTranslation = new SystemTranslation($this->getLanguage());
        if (!$idVariation) {
            $_SESSION['error'] = $systemTranslation->translate('no-product-set');
            return $this->redirect('order', 'cart');
        }

        $productManager = new ProductManager($this->getLanguage());

        $variation = $productManager->getVariationById($idVariation);

        if (!$variation) {
            $_SESSION['error'] = $systemTranslation->translate('product-does-not-exist');
            return $this->redirect('order', 'cart');
        }

        $_SESSION['cart'][] = $variation->getIdVariation();

        if (empty($_SESSION['idUser'])) {
            return $this->redirect('order', 'cart');
        }

        $orderManager = new OrderManager($this->getLanguage());

        if (!empty($_SESSION['idOrder'])) {
            $order = $orderManager->getOrderById($_SESSION['idOrder']);
        } else {
            $order = new Order;
            $order->setIdUser($_SESSION['idUser'])
                ->setInsertTime(new DateTime)
                ->setShippingCosts(0)
                ->setStatus('cart');

            if (!$orderManager->save($order)) {
                $_SESSION['error'] = $systemTranslation->translate('could-not-save');
                return $this->redirect('order', 'cart');
            }
        }

        $orderLine = new OrderLine;
        $orderLine->setIdOrder($order->getIdOrder())
            ->setIdVariation($variation->getIdVariation())
            ->setPrice($variation->getPrice())
            ->setAmount(1)
            ->setTax(0);

        // Reinitialize the order lines in the order so that only the new order line will be saved.
        $order->setOrderLines(array());
        // Save the order and the new order line.
        $order->addOrderLine($orderLine);

        $orderManager->save($order);

        return $this->redirect('order', 'cart');
    }

    public function cartAction()
    {
        if (!empty($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        } else {
            $error = '';
        }

        $productManager = new ProductManager($this->getLanguage());
        $products = array();

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $idVariation) {
                $product = $productManager->getProductByVariation($idVariation);
            }
        }

        $orderManager = new OrderManager($this->getLanguage());

        if (!empty($_SESSION['idOrder'])) {
            $order = $orderManager->getOrderById($_SESSION['idOrder']);
        } else {
            $order = new Order;
            $order->setInsertTime(new DateTime)
                ->setShippingCosts(0)
                ->setStatus('cart');
        }

        $systemTranslation = new SystemTranslation($this->getLanguage());

        $this->template->setTitle(ucfirst($systemTranslation->translate('cart')));
        $this->template->addBreadcrumb('order/cart', $systemTranslation->translate('cart'));

        $values = array(
            'error' => $error,
            'products' => $products,
            'order' => $order,
            'systemTranslation' => $systemTranslation
        );

        return $this->write($values);
    }
}
