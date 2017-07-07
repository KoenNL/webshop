<?php
$systemTranslation = $controller->getvalue('systemTranslation');

?>
<div class="container" id="content">
    <div class="row">
        <h1 class="inner-title"<?php echo ucfirst($systemTranslation)?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h3>Resultaat Zoekopdracht</h3>
    </div>
</div>
<div class="row product-selection-container">
     <div class="col-md-12 product-result-container">
        <div class="row">
            <div class="col-md-3 col-sm-12 product-overview-box">
                <a href="?page=product" title="Cars Jeans Baggy">
                    <img class="product-image" src="images/Product%20jeans.jpg">
                </a>
                <div class="product-description">
                    <h3 class="product-brand">
                        <a href="?page=product" title="Cars Jeans Baggy">Cars</a>
                    </h3>
                    <p class="product-title">
                        <a href="?page=product" title="Cars Jeans Baggy">Jeans Baggy <span
                                class="product-price">&euro; 79,95</span></a>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 product-overview-box">
                <a href="?page=product" title="Cars Jeans Baggy">
                    <img class="product-image" src="images/Product%20shirt.jpg">
                </a>
                <div class="product-description">
                    <h3 class="product-brand">
                        <a href="?page=product" title="Cars Jeans Baggy">Legendary</a>
                    </h3>
                    <p class="product-title">
                        <a href="?page=product" title="Cars Jeans Baggy">T-shirt <span class="product-price">&euro; 39,95</span></a>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 product-overview-box">
                <a href="?page=product" title="Cars Jeans Baggy">
                    <img class="product-image" src="images/Product%20jeans%202.jpg">
                </a>
                <div class="product-description">
                    <h3 class="product-brand">
                        <a href="?page=product" title="Cars Jeans Baggy">Vingino</a>
                    </h3>
                    <p class="product-title">
                        <a href="?page=product" title="Cars Jeans Baggy">Jeans Baggy <span
                                class="product-price">&euro; 79,95</span></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-12 product-overview-box">
                <a href="?page=product" title="Cars Jeans Baggy">
                    <img class="product-image" src="images/Product%20top.jpg">
                </a>
                <div class="product-description">
                    <h3 class="product-brand">
                        <a href="?page=product" title="Cars Jeans Baggy">Noize</a>
                    </h3>
                    <p class="product-title">
                        <a href="?page=product" title="Cars Jeans Baggy">Top <span class="product-price">&euro; 79,95</span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$systemTranslation = $controller->getValue('systemTranslation');
$products = $controller->getValue('products') ? $controller->getValue('products') : array();
?>
<div class="container" id="content">
    <div class="row">
        <h1 class="inner-title"><?php echo ucfirst($systemTranslation->translate('new-search')); ?></h1>
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