<?php

namespace Model\Email;

use Main\Config;
use Model\Order\Order;
use Model\Shop\ShopManager;
use Model\Translation\SystemTranslation;
use Model\User\User;
use PHPMailer;

class EmailManager
{

    public function __construct()
    {
        require_once Config::getValue('path.base') . 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    }

    public function sendConfirmation(Order $order, User $user)
    {
        $shopManager = new ShopManager;
        $shop = $shopManager->getShopById(Config::getValue('idShop'));

        $systemTranslation = new SystemTranslation($_SESSION['language']);

        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = Config::getValue('smtp.host');;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = Config::getValue('smtp.username');                 // SMTP username
        $mail->Password = Config::getValue('smtp.password');;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = Config::getValue('smtp.port');;                                    // TCP port to connect to

        $mail->setFrom($shop->getEmailAddress(), $shop->getName());
        $mail->addAddress($user->getEmailAddress(), $user->getName());
        $mail->addReplyTo($shop->getEmailAddress(), $shop->getName());
        $mail->isHTML(true);

        $mail->Subject = ucfirst($systemTranslation->translate('order-confirmation'));
        $mail->Body = ucfirst($systemTranslation->translate('email-intro')) . ' ' . $user->getName() . ',<br><br><p>';
        $mail->Body .= $systemTranslation->translate('order-confirmation-message');
        $mail->Body .= '
            <table>
                <tr>
                    <th width="50%">' . ucfirst($systemTranslation->translate('product')) . '</th>
                    <th width="10%">' . ucfirst($systemTranslation->translate('amount')) . '</th>
                    <th width="20%">' . ucfirst($systemTranslation->translate('price-per-piece')) . '</th>
                    <th width="20%">' . ucfirst($systemTranslation->translate('subtotal')) . '</th>
                </tr>';

        foreach ($order->getOrderLines() as $orderLine) {
            $features = '';
            foreach ($orderLine->getProduct()->getSelectedVariation()->getFeatureValues() as $feature) {
                $features .= $feature->getValue() . ' ';
            }
            $mail->Body .= '
                <tr>
                    <td>' . $orderLine->getProduct()->getName() . ' ' . $features . '</td>
                    <td>' . $orderLine->getAmount() . '</td>
                    <td>&euro; ' . number_format($orderLine->getPrice(), 2, ',', '.') . '</td>
                    <td>&euro; ' . number_format($orderLine->getPrice() * $orderLine->getAmount(),2 , ',', '.') . '</td>
                </tr>';
        }

        $mail->Body .= '
            <tr>
                <td colspan="4">&nbsp</td>
            </tr>
            <tr>
                <td colspan="3">' . ucfirst($systemTranslation->translate('subtotal')) . '</td>
                <td>&euro; ' . number_format($order->getPrice(), 2, ',', '.') . '</td>
            </tr>
            <tr>
                <td colspan="3">' . ucfirst($systemTranslation->translate('shipping-cost')) . '</td>
                <td>&euro; ' . number_format($order->getShippingCosts(), 2, ',', '.') . '</td>
            </tr>
            <tr>
                <td colspan="3">' . ucfirst($systemTranslation->translate('total')) . '</td>
                <td>&euro; ' . number_format($order->getPrice() + $order->getShippingCosts(), 2, ',', '.') . '</td>
            </tr>
        </table></p>';

        $mail->Body .= ucfirst($systemTranslation->translate('email-end')) . ',<br>' . $shop->getName();

        $mail->AltBody = ucfirst($systemTranslation->translate('email-intro')) . ' ' . $user->getName() . ','
            . PHP_EOL . PHP_EOL . $systemTranslation->translate('order-confirmation-message')
            . PHP_EOL . PHP_EOL . ucfirst($systemTranslation->translate('email-end')) . ',' .PHP_EOL . $shop->getName();

        return $mail->send();
    }

}