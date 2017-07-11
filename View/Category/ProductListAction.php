<?php
$category = $controller->getValue('category');
$systemTranslation = $controller->getValue('systemTranslation');
$featureValues = $controller->getValue('featureValues');
?>
<div class="row">
    <div class="col-sm-12">
        <h3><?php echo ucfirst($systemTranslation->translate('features')); ?></h3>
    </div>
</div>
<div class="row product-selection-container">
    <div class="col-md-2 feature-selection-container">
        <form action="/category/productlist/<?php echo $category->getIdCategory(); ?>" method="get">
            <?php foreach ($controller->getValue('features') as $feature) : ?>
                <div class="feature-selection">
                    <h3><?php echo ucfirst($feature->getName()); ?></h3>
                    <?php foreach ($feature->getFeatureValues() as $featureValue) : ?>
                        <div class="checkbox">
                            <label for="features[<?php echo $feature->getIdFeature(); ?>][<?php echo $featureValue->getIdFeatureValue(); ?>]">
                                <input class="checkbox checkbox-submit"
                                       id="features[<?php echo $feature->getIdFeature(); ?>][<?php echo $featureValue->getIdFeatureValue(); ?>]"
                                       name="features[<?php echo $feature->getIdFeature(); ?>][<?php echo $featureValue->getIdFeatureValue(); ?>]"
                                       type="checkbox" <?php echo !empty($featureValues[$feature->getIdFeature()]) && in_array($featureValue->getIdFeatureValue(), $featureValues[$feature->getIdFeature()]) ? 'checked' : ''; ?>>
                                <?php echo $featureValue->getValue(); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </form>
    </div>
    <div class="col-md-10 product-result-container">
        <div class="row">
            <?php foreach ($controller->getValue('products') as $product) : ?>
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
            <?php endforeach; ?>
        </div>
    </div>
</div>
