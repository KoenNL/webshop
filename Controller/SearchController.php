<?php

/**
 * Created by PhpStorm.
 * User: Arie Schouten
 * Date: 28-6-2017
 * Time: 20:17
 */

namespace Controller;


use Main\Controller;
use Model\Product\ProductManager;
use Model\Translation\SystemTranslation;

class SearchController extends Controller
{
    public function searchAction($search=null)
    {
        if (empty($_POST['search'])) {
            return $this->write(array('error'=> 'dit is een test'));
        }
        $search = $_POST['search'];
        $productmanager = new ProductManager($this->getLanguage());
        $systemTranslation = new SystemTranslation($this->getLanguage());
        $products = $productmanager->getProducts($search);


        if (!$products) {
            return $this->write(array('error' => 'Zoek opdracht niet gevonden'));
        }

        $values = array('products'=>$products,
                        'systemTranslation'=>$systemTranslation);

        return $this->write($values);
    }

}

