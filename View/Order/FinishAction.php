<?php
$order = $controller->getValue('order');
$shop = $controller->getValue('shop');
$systemTranslation = $controller->getValue('systemTranslation');
?>
<div class="row">
    <div class="col-sm-12">
        <h2><?php echo ucfirst($systemTranslation->translate('thanks-for-your-order')); ?></h2>
        <p>
            <?php echo $systemTranslation->translate('thanks-for-order-message'); ?>
        </p>
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
                <td>&euro; <?php echo number_format($order->getPrice(),2 , ',', '.'); ?></td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php echo ucfirst($systemTranslation->translate('shipping-cost')); ?>
                    <i>(
                        <?php echo $systemTranslation->translate('shipping-costs-free-at') . ' &euro;'
                            . number_format($shop->getShippingCostsThreshold(),2 , ',', '.'); ?>)
                    </i>
                </td>
                <td>&euro; <?php echo number_format($order->getShippingCosts(), 2, ',', '.'); ?></td>
            </tr>
            <tr class="active">
                <td colspan="3"><strong><?php echo ucfirst($systemTranslation->translate('total')); ?></strong></td>
                <td><strong>&euro; <?php echo number_format($order->getPrice() + $order->getShippingCosts(),2 , ',', '.'); ?></strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>