<?php
$product = $controller->getValue('product');
if ($product) :
    ?>
    <div class="row">
        <div class="col-md-2 col-sm-4">
            <div class="row product-image-thumbnail">
                <div class="col-sm-12">
                    <a href="product/product" title="Grote weergave">
                        <img src="images/Product%20top.jpg" class="img-tiny img-selected">
                    </a>
                </div>
            </div>
            <div class="row product-image-thumbnail">
                <div class="col-sm-12">
                    <a href="product/product" title="Grote weergave">
                        <img src="images/Product%20top.jpg" class="img-tiny">
                    </a>
                </div>
            </div>
            <div class="row product-image-thumbnail">
                <div class="col-sm-12">
                    <a href="product/product" title="Grote weergave">
                        <img src="images/Product%20top.jpg" class="img-tiny">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-8">
            <img src="images/Product%20top.jpg" class="img-primary">
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <p>
                        <?php echo $product->getDescription(); ?>
                    </p>
                </div>
            </div>
            <form>
                <div class="row product-feature">
                    <div class="col-sm-2">
                        <label for="feature-maat">Maat</label>
                    </div>
                    <div class="col-sm-10">
                        <select class="selectpicker" id="feature-maat" name="feature-maat">
                            <option>S</option>
                            <option>M</option>
                            <option>L</option>
                            <option>XL</option>
                        </select>
                    </div>
                </div>
                <div class="row product-feature">
                    <div class="col-sm-2">
                        <label for="feature-kleur">Kleur</label>
                    </div>
                    <div class="col-sm-10">
                        <p id="feature-kleur">Zwart</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p class="product-price-large">&euro; 79,95</p>
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