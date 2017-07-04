<?php

namespace Controller;

use Main\Config;
use Main\Controller;
use Model\Order\Order;
use Model\Order\OrderManager;
use Model\Order\OrderLine;
use Model\Product\ProductManager;
use Model\Shop\ShopManager;
use Model\Translation\SystemTranslation;
use \DateTime;

class OrderController extends Controller
{

    public function addProductAction($idProduct = null)
    {
        $systemTranslation = new SystemTranslation($this->getLanguage());
        if (!$idProduct) {
            $_SESSION['error'] = $systemTranslation->translate('no-product-set');
            return $this->redirect('order', 'cart');
        }

        $productManager = new ProductManager($this->getLanguage());

        $features = !empty($_POST['features']) ? $_POST['features'] : array();

        $variation = $productManager->getVariationByFeatures($idProduct, $features);
        $variation->setFeatureValues($productManager->getFeatureValuesByVariation($variation->getIdVariation()));
        $product = $productManager->getProductById($idProduct);
        $product->setSelectedVariation($variation);

        $shopManager = new ShopManager;
        $shop = $shopManager->getShopById(Config::getValue('idShop'));

        if (!$variation) {
            $_SESSION['error'] = $systemTranslation->translate('product-does-not-exist');
            return $this->redirect('order', 'cart');
        }

        if (empty($_SESSION['order'])) {
            $order = new Order;
            $order->setInsertTime(new DateTime)
                ->setShippingCosts($shop->getShippingCosts())
                ->setShippingCostsThreshold($shop->getShippingCostsThreshold())
                ->setStatus('cart');
        } else {
            $order = $_SESSION['order'];
        }

        $orderLine = new OrderLine;
        $orderLine->setIdOrder($order->getIdOrder())
            ->setProduct($product)
            ->setPrice($variation->getPrice())
            ->setAmount(1)
            ->setTax($shop->getDefaultTax());

        // Add the new order line.
        $order->addOrderLine($orderLine);

        $_SESSION['order'] = $order;

        // If the user hasn't logged in; return without saving.
        if (empty($_SESSION['user'])) {
            return $this->redirect('order', 'cart');
        }

        $order->setIdUser($_SESSION['user']->getIdUser());

        $orderManager = new OrderManager($this->getLanguage());

        if (!$orderManager->save($order)) {
            $_SESSION['error'] = $systemTranslation->translate('could-not-save');
            return $this->redirect('order', 'cart');
        }

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

        if (empty($_SESSION['order'])) {
            $order = new Order;
            $order->setInsertTime(new DateTime)
                ->setShippingCosts(0)
                ->setStatus('cart');
        } else {
            $order = $_SESSION['order'];
        }

        $systemTranslation = new SystemTranslation($this->getLanguage());

        $this->template->setTitle(ucfirst($systemTranslation->translate('cart')));
        $this->template->addBreadcrumb('order/cart', $systemTranslation->translate('cart'));

        $shopManager = new ShopManager;
        $shop = $shopManager->getShopById(Config::getValue('idShop'));

        $values = array(
            'error' => $error,
            'order' => $order,
            'shop' => $shop,
            'systemTranslation' => $systemTranslation,
        );

        return $this->write($values);
    }

    public function changeOrderLineAmountAction()
    {
        // Force JSON output.
        $this->setExtension('json');

        $systemTranslation = new SystemTranslation($this->getLanguage());

        if (empty($_POST['idVariation']) || empty($_SESSION['order'])) {
            $_SESSION['error'] = $systemTranslation->translate('invalid-values');
            return $this->write(array('redirect' => '/order/cart'));
        }

        $idVariation = (int) $_POST['idVariation'];
        $order = $_SESSION['order'];

        foreach ($order->getOrderLines() as $orderLine) {
            if ($orderLine->getProduct()->getSelectedVariation()->getIdVariation() === $idVariation) {
                if (empty($_POST['amount']) || $_POST['amount'] <= 0) {
                    $order->removeOrderLine($orderLine);
                } else {
                    $orderLine->setAmount($_POST['amount']);
                    $order->removeOrderLine($orderLine);
                    $order->addOrderLine($orderLine);
                }
            }
        }

        $_SESSION['order'] = $order;

        return $this->write(array('redirect' => '/order/cart'));
    }
}
