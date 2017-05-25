<ul>
    <?php
    foreach ($controller->getValue('menu') as $menu) : ?>
        <li><?php echo $menu; ?></li>
    <?php endforeach; ?>
</ul>
