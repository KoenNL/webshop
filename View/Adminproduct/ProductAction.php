<?php
    $product = $controller->getValue('product');
    $systemTranslation = $controller->getValue('systemTranslation');
?>
<div class="form-group">
    <label for="language">Taal</label>
    <select id="language" class="selectpicker">
        <?php foreach ($controller->getValue('languages') as $language) : ?>
            <option value="<?php echo $language['idLanguage']; ?>"><?php echo $language['name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<form>
    <div class="row">
        <div class="col-md-8">
            <h2><?php echo ucfirst($systemTranslation->translate('general')); ?></h2>
            <div class="form-group">
                <label for="brand" class="required"><?php echo ucfirst($systemTranslation->translate('brand')); ?></label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $product->getBrand(); ?>" required>
            </div>
            <div class="form-group">
                <label for="name" class="required"><?php echo ucfirst($systemTranslation->translate('name')); ?></label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product->getName(); ?>" required>
            </div>
            <div class="form-group">
                <label for="price" class="required"><?php echo ucfirst($systemTranslation->translate('price')); ?></label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $product->getPrice(); ?>" required>
            </div>
            <div class="form-group">
                <label for="description"><?php echo ucfirst($systemTranslation->translate('description')); ?></label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="categories" class="required"><?php echo ucfirst($systemTranslation->translate('categories')); ?></label>
                <select class="form-control selectpicker" title="<?php echo ucfirst($systemTranslation->translate('categories')) . ' ' . $systemTranslation->translate('select'); ?>..." name="categories"
                        id="categories" multiple required>
                    <?php foreach ($controller->getValue('categories') as $category) : ?>
                        <option value="<?php echo $category->getIdCategory(); ?>" <?php echo $category->getParent() ? 'data-icon="glyphicon-minus"' : '' ;?>
                            <?php echo $product->hasCategory($category) ? 'selected' : ''; ?>>
                            <?php echo $category->getName(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="combination-discount"><?php echo ucfirst($systemTranslation->translate('combination-discount')); ?>
                    <input type="checkbox" id="combination-discount" name="combination-discount" <?php echo $product->getCombinationDiscount() ? 'selected' : ''; ?>>
                </label>
            </div>
            <h2><?php echo ucfirst($systemTranslation->translate('features')); ?></h2>
            <div class="row">
                <div class="col-md-12">
                    <select class="selectpicker" title="<?php echo ucfirst($systemTranslation->translate('add-feature')); ?>...">
                        <?php foreach ($controller->getValue('features') as $feature) : ?>

                        <?php endforeach; ?>
                        <option>Maat</option>
                        <option>Kleur</option>
                        <option>Breedtemaat</option>
                        <option>Lengtemaat</option>
                    </select>
                    <button type="button" class="btn btn-default btn-sm" title="<?php echo ucfirst($systemTranslation->translate('add-feature')); ?>"><span
                            class="glyphicon glyphicon-plus"></span></button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Maat</div>
                        <div class="panel-body">
                            <div class="checkbox">
                                <label for="feature-maat-s"><input class="checkbox" id="feature-maat-s"
                                                                   type="checkbox" checked>S</label>
                            </div>
                            <div class="checkbox">
                                <label for="feature-maat-m"><input class="checkbox" id="feature-maat-m"
                                                                   type="checkbox" checked>M</label>
                            </div>
                            <div class="checkbox">
                                <label for="feature-maat-l"><input class="checkbox" id="feature-maat-l"
                                                                   type="checkbox" checked>L</label>
                            </div>
                            <div class="checkbox">
                                <label for="feature-maat-xl"><input class="checkbox" id="feature-maat-xl"
                                                                    type="checkbox" checked>XL</label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Nieuw kenmerk...">
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-default" title="Toevoegen"><span class="glyphicon glyphicon-plus"</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h2><?php echo ucfirst($systemTranslation->translate('images')); ?></h2>
            <div class="row">
                <div class="col-md-8">
                    <img src="images/Product%20top.jpg" class="img-primary">
                    <a href="#" title="Wijzigen" class="pull-right" data-toggle="modal" data-target="#image-modal"><?php echo ucfirst($systemTranslation->translate('edit')); ?></a>
                </div>
                <div class="col-md-4">
                    <img src="images/Product%20top.jpg" class="img-tiny">
                    <img src="images/Product%20top.jpg" class="img-tiny">
                    <img src="images/Product%20top.jpg" class="img-tiny">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="submit" name="save" value="<?php echo ucfirst($systemTranslation->translate('save')); ?>" class="btn btn-primary">
            <a href="?page=productList" title="<?php echo ucfirst($systemTranslation->translate('back-to-summary')); ?>" class="btn btn-default"><?php echo ucfirst($systemTranslation->translate('back-to-summary')); ?></a>
            <a href="?page=productVariations" class="btn btn-default"><?php echo ucfirst($systemTranslation->translate('to-variations')); ?></a>
        </div>
    </div>
</form>
<div class="modal fade" id="image-modal" tabindex="-1" role="dialog" aria-labelledby="image-modal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="image-modal-label"><?php echo ucfirst($systemTranslation->translate('images')); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>Opgeslagen afbeeldingen</h2>
                        <input type="text" name="image-search" id="image-search" placeholder="<?php echo ucfirst($systemTranslation->translate('search')); ?>...">
                        <button type="button" class="btn btn-primary btn-sm"><?php echo ucfirst($systemTranslation->translate('search')); ?></button>
                        <div class="row">
                            <div class="well">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <figure class="text-center">
                                            <img src="images/Product%20top.jpg" class="img-tiny">
                                            <figcaption>Noize Top voorkant</figcaption>
                                        </figure>
                                    </div>
                                    <div class="col-sm-4">
                                        <figure class="text-center">
                                            <img src="images/Product%20jeans%202.jpg" class="img-tiny">
                                            <figcaption>Jeans 1 voorkant</figcaption>
                                        </figure>
                                    </div>
                                    <div class="col-sm-4">
                                        <figure class="text-center">
                                            <img src="images/Product%20shirt.jpg" class="img-tiny">
                                            <figcaption>Legendary Shirt voorkant</figcaption>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h2><?php echo ucfirst($systemTranslation->translate('upload-new-image')); ?></h2>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" id="new-image">
                        </div>
                        <div class="col-sm-6">
                            <input type="submit" value="<?php echo ucfirst($systemTranslation->translate('upload')); ?>" class="btn btn-primary btn-sm">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo ucfirst($systemTranslation->translate('close')); ?></button>
                <button type="button" class="btn btn-primary"><?php echo ucfirst($systemTranslation->translate('save')); ?></button>
            </div>
        </div>
    </div>
</div>