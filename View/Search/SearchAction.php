<?php
$systemTranslation = $controller->getValue('systemTranslation');
$products = $controller->getValue('products') ? $controller->getValue('products') : array();

if ($controller->getValue('error')) : ?>
<div class="col-sm-12 alert alert-danger">
    <?php echo $controller->getValue('error'); ?>
</div>
<?php endif; ?>
<div class="container" id="content">
    <div class="row">
        <?php if ($products) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="col-md-3 col-sm-12 product-overview-box">
                    <a href="/product/product/<?php echo $product->getUri(); ?>"
                       title="<?php echo $product->getBrand() . ' ' . $product->getName(); ?>">
                        <img class="product-image"
                             src="<?php echo $product->getPrimaryImage() ? $product->getPrimaryImage()->getPath() : ''; ?>">
                    </a>
                    <div class="product-description">
                        <h3 class="product-brand">
                            <a href="/product/product/<?php echo $product->getUri(); ?>"
                               title="<?php echo $product->getBrand() . ' ' . $product->getName(); ?>"><?php echo $product->getBrand(); ?></a>
                        </h3>
                        <p class="product-title">
                            <a href="/product/product/<?php echo $product->getUri(); ?>"
                               title="<?php echo $product->getBrand() . ' ' . $product->getName(); ?>">
                                <?php echo $product->getName(); ?>
                                <span class="product-price">&euro; <?php echo number_format($product->getPrice(), 2, ',', '.'); ?></span>
                            </a>
                        </p>
                    </div>
                </div>
            <?php endforeach;; ?>
        <?php else : ?>
            <div class="col-sm-12">
                <i><?php echo ucfirst($systemTranslation->translate('no-results')); ?></i>
            </div>
        <?php endif; ?>
    </div>
</div>