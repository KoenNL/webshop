<?php
$product = $controller->getValue('product');
if ($product) :
    ?>
    <div class="row">
        <div class="col-md-2 col-sm-4">
            <?php foreach ($product->getImages() as $image) : ?>
            <div class="row product-image-thumbnail">
                <div class="col-sm-12">
                    <a href="#" title="Grote weergave">
                        <img src="<?php echo $image->getPath(); ?>" class="img-tiny img-selected">
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4 col-sm-8">
            <img src="<?php echo $product->getImages() ? $product->getImages()[0]->getPath() : ''; ?>" class="img-primary">
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <p>
                        <?php echo $product->getDescription(); ?>
                    </p>
                </div>
            </div>
            <form action="/order/addproduct/<?php echo $product->getIdProduct(); ?>" method="post">
                <?php foreach ($controller->getValue('features') as $feature) : ?>
                    <div class="row product-feature">
                        <div class="col-sm-2">
                            <label for="feature-<?php echo $feature->getIdFeature(); ?>">
                                <?php echo ucfirst($feature->getName()); ?>
                            </label>
                        </div>
                        <div class="col-sm-10">
                            <?php if (count($feature->getFeatureValues()) > 1) : ?>
                            <select class="selectpicker" id="features[<?php echo $feature->getIdFeature(); ?>]"
                                    name="features[<?php echo $feature->getIdFeature(); ?>]">
                                <?php foreach ($feature->getFeatureValues() as $featureValue) : ?>
                                    <option value="<?php echo $featureValue->getIdFeatureValue(); ?>">
                                        <?php echo $featureValue->getValue(); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                                <p><?php echo $feature->getFeatureValues()[0]->getValue(); ?></p>
                                <input type="hidden" name="features[<?php echo $feature->getIdFeature(); ?>"
                                       value="<?php echo $feature->getFeatureValues()[0]->getIdFeatureValue(); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <div class="col-sm-12">
                        <p class="product-price-large">
                            &euro; <?php echo number_format($product->getPrice(), 2, ',', '.'); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-primary" value="Plaats in winkelwagen" name="order">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-sm-12">
            <h2><?php echo $controller->getValue('title'); ?></h2>
            <p><?php echo $controller->getValue('notFound'); ?></p>
            <a href="">Ga terug</a>
        </div>
    </div>

<?php endif; ?>
