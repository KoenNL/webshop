<?php

namespace Controller;


use Main\Controller;
use Model\Product\ProductManager;
use Model\Translation\SystemTranslation;

class PageController extends Controller
{

    public function homeAction()
    {
        $systemTranslation = new SystemTranslation($this->getLanguage());

        $this->template->setTitle('Home');

        $productManager = new ProductManager($this->getLanguage());

        $products = $productManager->getNewProducts(4);

        $values = array(
            'systemTranslation' => $systemTranslation,
            'products' => $products,
            'homepage' => true
        );
        
        return $this->write($values);
    }

}