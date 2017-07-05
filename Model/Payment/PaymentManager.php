<?php

namespace Model\Payment;

use Main\Config;
use Model\Order\Order;
use Model\Shop\ShopManager;
use Mollie_API_Client;
use Mollie_API_Exception;
use \Exception;

class PaymentManager
{

    public function __construct()
    {
        require_once Config::getValue('path.base') . '/vendor/mollie/mollie-api-php/src/Mollie/API/Autoloader.php';
    }

    public function createPayment(Order $order)
    {
        if (!Config::getValue('mollieAPIKey')) {
            throw new Exception('No Mollie API key set');
        }

        $mollie = new Mollie_API_Client;
        $mollie->setApiKey(Config::getValue('mollieAPIKey'));

        $shopManager = new ShopManager;
        $shop = $shopManager->getShopById(Config::getValue('idShop'));

        try {
            $payment = $mollie->payments->create(
                array(
                    'amount' => $order->getPrice(),
                    'description' => $shop->getName() . ' ' . $order->getInsertTime()->format('Y-m-d H:i:s'),
                    'redirectUrl' => Config::getValue('path.host') . '/order/finish',
                    'metadata' => array(
                        'order_id' => $order->getIdOrder()
                    )
                )
            );

            /*
             * Send the customer off to complete the payment.
             */
            header("Location: " . $payment->getPaymentUrl());
            exit;
        } catch (Mollie_API_Exception $e) {
            throw new Exception('API call failed: ' . $e->getMessage() . ' on field ' . $e->getField());
        }

    }
}