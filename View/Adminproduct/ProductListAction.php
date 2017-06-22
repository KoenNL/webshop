<?php
$products = $controller->getValue('products');
?>
<div class="row">
    <div class="col-sm-4">
        <input type="text" class="form-control" placeholder="<?php echo ucfirst($controller->getValue('search')); ?>...">
    </div>
    <div class="col-sm-4">
        <button type="button" class="btn btn-primary btn-sm"><?php echo ucfirst($controller->getValue('search')); ?></button>
    </div>
    <div class="col-sm-4">
        <a href="/adminproduct/product" title="<?php echo ucfirst($controller->getValue('newProduct')); ?>"
           class="btn btn-primary btn-sm"><?php echo ucfirst($controller->getValue('newProduct')); ?></a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Merk</th>
                <th>Naam</th>
                <th>Prijs</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($products) : ?>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $product->getBrand(); ?></td>
                        <td><?php echo $product->getName(); ?></td>
                        <td>&euro; <?php echo $product->getPrice(); ?></td>
                        <td>
                            <a href="/adminproduct/product/<?php echo $product->getIdProduct(); ?>"
                               class="btn btn-default" title="Bewerken">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a href="/adminproduct/product/<?php echo $product->getIdProduct(); ?>"
                               class="btn btn-default" title="Vertalen">
                                <span class="glyphicon glyphicon-globe"></span>
                            </a>
                            <button type="button" class="btn btn-danger" title="Verwijderen"
                                    data-id="<?php echo $product->getIdProduct(); ?>">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4"><i><?php echo $controller->getValue('noResults'); ?></i></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
