<?php

namespace Model\Product;

use Main\Database;

class ProductManager
{
    public static function getList()
    {
        Database::query('SELECT * FROM `product`');

        $products = array();

        while ($product = Database::fetchObject('Model\\Product\\Product')) {
            $products[] = $product;
        }

        return $products;
    }
}