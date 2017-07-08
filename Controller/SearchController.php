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

    public function searchAction($search = null)
    {
        $search = $_POST['search'];
        $productmanager = new ProductManager($this->getLanguage());
        $products = $productmanager->getProducts($search);
        $systemTranslation = new SystemTranslation($this->getLanguage());
        if (empty($_POST['search'])) {
            return $this->write(array('error' => ucfirst($systemTranslation->translate('insert-query'))));
        }
        if (!$products) {
            return $this->write(array('error' => ucfirst($systemTranslation->translate('no-search-results'))));
        }

        $values = array('products' => $products,
            'systemTranslation' => $systemTranslation);

        return $this->write($values);
    }

}

