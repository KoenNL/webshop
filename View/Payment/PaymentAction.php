<div class="row">
    <div class="col-sm-12">
        <h2><?php echo ucfirst($systemTranslation->translate('thanks-for-ordering')); ?></h2>
        <p>
            <?php echo ucfirst($systemTranslation->translate('order-message')); ?>
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
                <th width="10%"><?php echo ucfirst($systemTranslation->translate('ammount')); ?></th>
                <th width="20%"><?php echo ucfirst($systemTranslation->translate('price-each')); ?></th>
                <th width="20%"><?php echo ucfirst($systemTranslation->translate('subtotal')); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><img src="images/Product%20top.jpg" class="img-tiny pull-left"><h4>Noize</h4>
                    <p>Top Zwart M</p></td>
                <td>2</td>
                <td>&euro; 79,95</td>
                <td>&euro; 159,90</td>
            </tr>
            <tr>
                <td><img src="images/Product%20jeans%202.jpg" class="img-tiny pull-left"><h4>Vingino</h4>
                    <p>Jeans 30 34</p></td>
                <td>2</td>
                <td>&euro; 79,95</td>
                <td>&euro; 79,95</td>
            </tr>
            <tr class="active">
                <td colspan="3">Subtotaal</td>
                <td>&euro; 239,85</td>
            </tr>
            <tr>
                <td colspan="3"><?php echo ucfirst($systemTranslation->translate('shipping-costs')); ?> <i><?php echo ucfirst($systemTranslation->translate('free-shipping')); ?>
                        </i></td>
                <td>&euro; 0,00</td>
            </tr>
            <tr class="active">
                <td colspan="3"><strong><?php echo ucfirst($systemTranslation->translate('total')); ?></strong></td>
                <td><strong>&euro; 239,85</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>