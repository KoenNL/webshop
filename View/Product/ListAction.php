<h1>Lijstje</h1>
<table>
    <tr>
        <th>Naam</th>
        <th>Omschrijving</th>
        <th>Prijs</th>
    </tr>
    <?php if (!$controller->getValue('productList')) : ?>
        <tr><td colspan="3">Geen resultaten</td></tr>
    <?php else : ?>
        <?php foreach ($controller->getValue('productList') as $product) : ?>
            <tr>
                <td><?php echo $product->getName(); ?></td>
                <td><?php echo $product->getDescription(); ?></td>
                <td>&euro; <?php echo number_format($product->getPrice(), 2, ',', '.'); ?></td>
            </tr>
            <?php
        endforeach;
    endif;
    ?>
</table>