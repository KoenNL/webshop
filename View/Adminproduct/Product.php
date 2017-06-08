<?php
    $product = $controller->getValue('product');
?>
<div class="form-group">
    <label for="language">Taal</label>
    <select id="language" class="selectpicker">
        <?php foreach ($controller->getValue('languages') as $language) : ?>
            <option value="<?php echo $language['idLanguage']; ?>"><?php echo $language['language']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<form>
    <div class="row">
        <div class="col-md-8">
            <h2><?php echo $controller->getValue('general'); ?></h2>
            <div class="form-group">
                <label for="brand" class="required"><?php echo $controller->getValue('brand'); ?></label>
                <input type="text" class="form-control" id="brand" name="brand" required>
            </div>
            <div class="form-group">
                <label for="name" class="required"><?php echo $controller->getValue('name'); ?></label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="price" class="required"><?php echo $controller->getValue('price'); ?></label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="description"><?php echo $controller->getValue('description'); ?></label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="categories" class="required"><?php echo $controller->getValue('categories'); ?></label>
                <select class="form-control selectpicker" title="<?php echo $controller->getValue('categories') . ' ' . $controller->getValue('select'); ?>..." name="categories"
                        id="categories" multiple required>
                    <option>Herenmode</option>
                    <option data-icon="glyphicon-minus">Jeans</option>
                    <option data-icon="glyphicon-minus">Shirts</option>
                    <option data-icon="glyphicon-minus">Schoenen</option>
                    <option>Damesmode</option>
                    <option data-icon="glyphicon-minus">Rokken</option>
                    <option data-icon="glyphicon-minus">Tops</option>
                    <option data-icon="glyphicon-minus">Schoenen</option>
                    <option>Tienermode</option>
                    <option data-icon="glyphicon-minus">Jeans</option>
                    <option data-icon="glyphicon-minus">Shirts</option>
                    <option data-icon="glyphicon-minus">Schoenen</option>
                </select>
            </div>
            <div class="form-group">
                <label for="combination-discount">Combinatiekorting
                    <input type="checkbox" id="combination-discount" name="combination-discount">
                </label>
            </div>
            <h2>Kenmerken</h2>
            <div class="row">
                <div class="col-md-12">
                    <select class="selectpicker" title="Voeg een kenmerk toe...">
                        <option>Maat</option>
                        <option>Kleur</option>
                        <option>Breedtemaat</option>
                        <option>Lengtemaat</option>
                    </select>
                    <button type="button" class="btn btn-default btn-sm" title="Kenmerk toevoegen"><span
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
                    <div class="panel panel-default">
                        <div class="panel-heading">Kleur</div>
                        <div class="panel-body">
                            <div class="checkbox">
                                <label for="feature-kleur-blauw"><input class="checkbox" id="feature-kleur-blauw"
                                                                        type="checkbox" checked>Blauw</label>
                            </div>
                            <div class="checkbox">
                                <label for="feature-kleur-geel"><input class="checkbox" id="feature-kleur-geel"
                                                                       type="checkbox" checked>Geel</label>
                            </div>
                            <div class="checkbox">
                                <label for="feature-kleur-groen"><input class="checkbox" id="feature-kleur-groen"
                                                                        type="checkbox" checked>Groen</label>
                            </div>
                            <div class="checkbox">
                                <label for="feature-kleur-oranje"><input class="checkbox" id="feature-kleur-oranje"
                                                                         type="checkbox" checked>Oranje</label>
                            </div>
                            <div class="checkbox">
                                <label for="feature-kleur-rood"><input class="checkbox" id="feature-kleur-rood"
                                                                       type="checkbox" checked>Rood</label>
                            </div>
                            <div class="checkbox">
                                <label for="feature-kleur-zwart"><input class="checkbox" id="feature-kleur-zwart"
                                                                        type="checkbox" checked>Zwart</label>
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
            <h2>Afbeeldingen</h2>
            <div class="row">
                <div class="col-md-8">
                    <img src="images/Product%20top.jpg" class="img-primary">
                    <a href="#" title="Wijzigen" class="pull-right" data-toggle="modal" data-target="#image-modal">Wijzigen</a>
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
            <input type="submit" name="save" value="Opslaan" class="btn btn-primary">
            <a href="?page=productList" title="Terug naar overzicht" class="btn btn-default">Terug naar overzicht</a>
            <a href="?page=productVariations" class="btn btn-default">Naar variaties</a>
        </div>
    </div>
</form>
<div class="modal fade" id="image-modal" tabindex="-1" role="dialog" aria-labelledby="image-modal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="image-modal-label">Afbeeldingen</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>Opgeslagen afbeeldingen</h2>
                        <input type="text" name="image-search" id="image-search" placeholder="Zoeken...">
                        <button type="button" class="btn btn-primary btn-sm">Zoeken</button>
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
                        <h2>Nieuwe afbeelding uploaden</h2>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" id="new-image">
                        </div>
                        <div class="col-sm-6">
                            <input type="submit" value="Uploaden" class="btn btn-primary btn-sm">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                <button type="button" class="btn btn-primary">Opslaan</button>
            </div>
        </div>
    </div>
</div>