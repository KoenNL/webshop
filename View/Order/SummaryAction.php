<?php
$order = $controller->getValue('order');
$user = $controller->getValue('user');
$shop = $controller->getValue('shop');
$systemTranslation = $controller->getValue('systemTranslation');

if ($controller->getValue('error')) : ?>
    <div class="alert alert-danger"><?php echo $controller->getValue('error'); ?></div>
<?php endif; ?>
<div class="row" id="cart-menu">
    <div class="col-sm-3">
        <a href="/order/cart" title="<?php echo ucfirst($systemTranslation->translate('cart')); ?>">
            <?php echo ucfirst($systemTranslation->translate('cart')); ?>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="#" title="Inloggen/Registreren" data-toggle="modal" data-target="#login-modal">
            <?php echo ucwords($systemTranslation->translate('login-register')); ?>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="/order/summary" class="text-active"
           title="<?php echo ucfirst($systemTranslation->translate('summary')); ?>">
            <?php echo ucfirst($systemTranslation->translate('summary')); ?>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="/order/payment" class="inactive"
           title="<?php echo ucfirst($systemTranslation->translate('payment')); ?>">
            <?php echo ucfirst($systemTranslation->translate('payment')); ?>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h2><?php echo ucfirst($systemTranslation->translate('order')); ?></h2>
        <table class="table table-hover shopping-cart">
            <thead>
            <tr>
                <th width="50%"><?php echo ucfirst($systemTranslation->translate('product')); ?></th>
                <th width="10%"><?php echo ucfirst($systemTranslation->translate('amount')); ?></th>
                <th width="20%"><?php echo ucfirst($systemTranslation->translate('price-per-piece')); ?></th>
                <th width="20%"><?php echo ucfirst($systemTranslation->translate('subtotal')); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($order->getOrderLines()) === 0) : ?>
                <tr>
                    <td colspan="5"><?php echo ucfirst($systemTranslation->translate('cart-is-empty')); ?></td>
                </tr>
            <?php else : ?>
                <?php foreach ($order->getOrderLines() as $orderLine) :
                    $product = $orderLine->getProduct();
                    ?>
                    <tr>
                        <td>
                            <img src="<?php echo $product->getPrimaryImage() ? $product->getPrimaryImage()->getPath() : ''; ?>" class="img-tiny pull-left">
                            <h4><?php echo $product->getBrand(); ?></h4>
                            <p><?php echo $product->getName(); ?>
                                <i>
                                    <?php foreach ($product->getSelectedVariation()->getFeatureValues() as $featureValue) : ?>
                                        <?php echo $featureValue->getValue() . ' '; ?>
                                    <?php endforeach; ?>
                                </i></p>
                        </td>
                        <td>
                            <p><?php echo $orderLine->getAmount(); ?></p>
                        </td>
                        <td>
                            &euro; <?php echo number_format($orderLine->getPrice(), 2, ',', '.'); ?>
                        </td>
                        <td>
                            &euro; <?php echo number_format($orderLine->getPrice() * $orderLine->getAmount(), 2, ',', '.'); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr class="active">
                <td colspan="3"><?php echo ucfirst($systemTranslation->translate('subtotal')); ?></td>
                <td>&euro; <?php echo number_format($order->getPrice(), 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php echo ucfirst($systemTranslation->translate('shipping-cost')); ?>
                    <i>(
                        <?php echo $systemTranslation->translate('shipping-costs-free-at') . ' &euro;'
                            . number_format($shop->getShippingCostsThreshold(), 2, ',', '.'); ?>)
                    </i>
                </td>
                <td>&euro; <?php echo number_format($order->getShippingCosts(), 2, ',', '.'); ?></td>
            </tr>
            <tr class="active">
                <td colspan="3"><strong><?php echo ucfirst($systemTranslation->translate('total')); ?></strong></td>
                <td>
                    <strong>&euro; <?php echo number_format($order->getPrice() + $order->getShippingCosts(), 2, ',', '.'); ?></strong>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h2><?php echo ucfirst($systemTranslation->translate('my-data')); ?></h2>
        <table class="table table-hover">
            <tbody>
            <tr>
                <td><?php echo ucfirst($systemTranslation->translate('name')); ?></td>
                <td><?php echo $user->getName(); ?></td>
            </tr>
            <tr>
                <td><?php echo ucfirst($systemTranslation->translate('address')); ?></td>
                <td><?php echo $user->getAddress(); ?></td>
            </tr>
            <tr>
                <td><?php echo ucfirst($systemTranslation->translate('postalcode')); ?></td>
                <td><?php echo $user->getPostalCode(); ?></td>
            </tr>
            <tr>
                <td><?php echo ucfirst($systemTranslation->translate('city')); ?></td>
                <td><?php echo $user->getCity(); ?></td>
            </tr>
            <tr>
                <td><?php echo ucfirst($systemTranslation->translate('email-address')); ?></td>
                <td><?php echo $user->getEmailAddress(); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-sm-6">
        <a href="/order/cart" title="<?php echo ucfirst($systemTranslation->translate('change-cart')); ?>">
            <?php echo ucfirst($systemTranslation->translate('change-cart')); ?>
        </a>
    </div>
    <div class="col-md-4 col-md-offset-6 col-sm-6">
        <?php if (count($order->getOrderLines()) > 0) : ?>
            <a href="/order/payment" title="<?php echo ucfirst($systemTranslation->translate('payment')); ?>"
               class="btn btn-primary">
                <?php echo ucfirst($systemTranslation->translate('payment')); ?>
            </a>
        <?php endif; ?>
    </div>
</div>