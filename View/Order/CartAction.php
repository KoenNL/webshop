<?php
$order = $controller->getValue('order');
$products = $controller->getValue('products') ? $controller->getValue('products') : array();
$systemTranslation = $controller->getValue('systemTranslation');

if ($controller->getValue('error')) : ?>
<div class="alert alert-danger"><?php echo $controller->getValue('error'); ?></div>
<?php endif; ?>

<div class="row" id="cart-menu">
    <div class="col-sm-3">
        <a href="?page=cart" class="text-active" title="<?php echo ucfirst($systemTranslation->translate('cart')); ?>">
            <?php echo ucfirst($systemTranslation->translate('cart')); ?>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="?page=register" class="inactive" title="Inloggen/Registreren">
            <?php echo ucwords($systemTranslation->translate('login-register')); ?>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="?page=summary" class="inactive" title="<?php echo ucfirst($systemTranslation->translate('summary')); ?>">
            <?php echo ucfirst($systemTranslation->translate('summary')); ?>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="?page=payment" class="inactive" title="<?php echo ucfirst($systemTranslation->translate('payment')); ?>">
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
                <th width="20%"><?php echo ucfirst($systemTranslation->translate('price-per-piece')); ?></th>
                <th width="20%"><?php echo ucfirst($systemTranslation->translate('subtotal')); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) : ?>
            <tr>
                <td>
                    <img src="<?php echo $product->getPrimaryImage()->getPath(); ?>" class="img-tiny pull-left">
                    <h4><?php echo $product->getBrand(); ?></h4>
                    <p><?php echo $product->getName(); ?></p>
                </td>
                <td>
                    <input type="number" class="form-control" value="1">
                </td>
                <td>
                    &euro; <?php echo number_format($product->getPrice(), 2, ',', '.'); ?>
                </td>
                <td>
                    &euro; <?php echo number_format($product->getPrice(), 2, ',', '.'); ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr class="active">
                <td colspan="3"><?php echo ucfirst($systemTranslation->translate('subtotal')); ?></td>
                <td>&euro; 300,00</td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php echo ucfirst($systemTranslation->translate('shipping-cost')); ?>
                    <i>(Bij een bestelling van meer dan &euro; 75,- zijn de verzendkosten gratis)</i>
                </td>
                <td>&euro; <?php echo number_format($order->getShippingCosts(),2 , ',', '.'); ?></td>
            </tr>
            <tr class="active">
                <td colspan="3"><strong><?php echo ucfirst($systemTranslation->translate('total')); ?></strong></td>
                <td><strong>&euro; 300,00</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-sm-6">
        <a href="?page=home" title="<?php echo ucfirst($systemTranslation->translate('continue-shopping')); ?>">
            <?php echo ucfirst($systemTranslation->translate('continue-shopping')); ?>
        </a>
    </div>
    <div class="col-md-4 col-md-offset-6 col-sm-6">
        <a href="?page=register" title="<?php echo ucwords($systemTranslation->translate('login-register')); ?>" class="btn btn-primary">
            <?php echo ucfirst($systemTranslation->translate('continue-order')); ?>
        </a>
    </div>
</div>