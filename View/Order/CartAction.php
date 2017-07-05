<?php
$shop = $controller->getValue('shop');
$order = $controller->getValue('order');
$products = $controller->getValue('products') ? $controller->getValue('products') : array();
$systemTranslation = $controller->getValue('systemTranslation');

if ($controller->getValue('error')) : ?>
    <div class="alert alert-danger"><?php echo $controller->getValue('error'); ?></div>
<?php endif; ?>
<div class="row" id="cart-menu">
    <div class="col-sm-3">
        <a href="/order/cart" class="text-active" title="<?php echo ucfirst($systemTranslation->translate('cart')); ?>">
            <?php echo ucfirst($systemTranslation->translate('cart')); ?>
        </a>
    </div>
    <div class="col-sm-3">
        <?php if (!empty($_SESSION['user'])) : ?>
            <a href="/order/summary" class="inactive" title="Inloggen/Registreren">
                <?php echo ucwords($systemTranslation->translate('login-register')); ?>
            </a>
        <?php else : ?>
            <a href="#" class="inactive" title="Inloggen/Registreren" data-toggle="modal" data-target="#login-modal">
                <?php echo ucwords($systemTranslation->translate('login-register')); ?>
            </a>
        <?php endif; ?>
    </div>
    <div class="col-sm-3">
        <a href="/order/summary" class="inactive"
           title="<?php echo ucfirst($systemTranslation->translate('summary')); ?>">
            <?php echo ucfirst($systemTranslation->translate('summary')); ?>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="#" class="inactive"
           title="<?php echo ucfirst($systemTranslation->translate('payment')); ?>">
            <?php echo ucfirst($systemTranslation->translate('payment')); ?>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-hover shopping-cart">
            <thead>
            <tr>
                <th width="50%"><?php echo ucfirst($systemTranslation->translate('product')); ?></th>
                <th width="10%"><?php echo ucfirst($systemTranslation->translate('amount')); ?></th>
                <th width="15%"><?php echo ucfirst($systemTranslation->translate('price-per-piece')); ?></th>
                <th width="20%"><?php echo ucfirst($systemTranslation->translate('subtotal')); ?></th>
                <th width="5%">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($order->getOrderLines()) === 0) : ?>
                <tr>
                    <td colspan="5"><?php echo $systemTranslation->translate('cart-is-empty'); ?></td>
                </tr>
            <?php else : ?>
                <?php foreach ($order->getOrderLines() as $orderLine) :
                    $product = $orderLine->getProduct();
                    ?>
                    <tr>
                        <td>
                            <img src="<?php echo $product->getPrimaryImage()->getPath(); ?>" class="img-tiny pull-left">
                            <h4><?php echo $product->getBrand(); ?></h4>
                            <p><?php echo $product->getName(); ?>
                                <i>
                                    <?php foreach ($product->getSelectedVariation()->getFeatureValues() as $featureValue) : ?>
                                        <?php echo $featureValue->getValue() . ' '; ?>
                                    <?php endforeach; ?>
                                </i></p>
                        </td>
                        <td>
                            <input type="number" class="form-control change-order-line-amount"
                                   value="<?php echo $orderLine->getAmount(); ?>"
                                   data-id-variation="<?php echo $orderLine->getProduct()->getSelectedVariation()->getIdVariation(); ?>">
                        </td>
                        <td>
                            &euro; <?php echo number_format($orderLine->getPrice(), 2, ',', '.'); ?>
                        </td>
                        <td>
                            &euro; <?php echo number_format($orderLine->getPrice() * $orderLine->getAmount(), 2, ',', '.'); ?>
                        </td>
                        <td>
                            <button class="btn btn-default btn-sm remove-order-line"
                                    data-id-variation="<?php echo $orderLine->getProduct()->getSelectedVariation()->getIdVariation(); ?>">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr class="active">
                <td colspan="3"><?php echo ucfirst($systemTranslation->translate('subtotal')); ?></td>
                <td>&euro; <?php echo number_format($order->getPrice(), 2, ',', '.'); ?></td>
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
            </tr>
            <tr class="active">
                <td colspan="3"><strong><?php echo ucfirst($systemTranslation->translate('total')); ?></strong></td>
                <td>
                    <strong>&euro; <?php echo number_format($order->getPrice() + $order->getShippingCosts(), 2, ',', '.'); ?></strong>
                </td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-sm-6">
        <a href="/page/home" title="<?php echo ucfirst($systemTranslation->translate('continue-shopping')); ?>">
            <?php echo ucfirst($systemTranslation->translate('continue-shopping')); ?>
        </a>
    </div>
    <div class="col-md-4 col-md-offset-6 col-sm-6">
        <?php if (!empty($_SESSION['user'])) : ?>
            <?php if (count($order->getOrderLines()) > 0) : ?>
                <a href="/order/summary" title="<?php echo ucfirst($systemTranslation->translate('summary')); ?>"
                   class="btn btn-primary">
                    <?php echo ucfirst($systemTranslation->translate('continue-order')); ?>
                </a>
            <?php endif; ?>
        <?php else : ?>
            <a href="#" title="<?php echo ucwords($systemTranslation->translate('login-register')); ?>"
               class="btn btn-primary" data-toggle="modal" data-target="#login-modal">
                <?php echo ucfirst($systemTranslation->translate('continue-order')); ?>
            </a>
        <?php endif; ?>
    </div>
</div>
