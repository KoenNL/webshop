<?php
    $systemTranslation = $controller->getValue('systemTranslation');
    $products = $controller->getValue('products') ? $controller->getValue('products') : array();
?>
<div class="container" id="content">
    <div class="row">
        <h1 class="inner-title"><?php echo ucfirst($systemTranslation->translate('new-products')); ?></h1>
    </div>
    <div class="row">
        <?php foreach ($products as $product) : ?>
        <div class="col-md-3 col-sm-12 product-overview-box">
            <a href="/product/product/<?php echo $product->getUri(); ?>" title="<?php echo $product->getBrand() . ' ' . $product->getName(); ?>">
                <img class="product-image" src="<?php echo $product->getPrimaryImage() ? $product->getPrimaryImage()->getPath() : ''; ?>">
            </a>
            <div class="product-description">
                <h3 class="product-brand">
                    <a href="/product/product/<?php echo $product->getUri(); ?>" title="<?php echo $product->getBrand() . ' ' . $product->getName(); ?>"><?php echo $product->getBrand(); ?></a>
                </h3>
                <p class="product-title">
                    <a href="/product/product/<?php echo $product->getUri(); ?>" title="<?php echo $product->getBrand() . ' ' . $product->getName(); ?>">
                        <?php echo $product->getName(); ?>
                        <span class="product-price">&euro; <?php echo number_format($product->getPrice(), 2, ',', '.'); ?></span>
                    </a>
                </p>
            </div>
        </div>
        <?php endforeach;; ?>
    </div>
</div>