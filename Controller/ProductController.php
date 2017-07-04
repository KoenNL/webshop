<?php

namespace Controller;

use Main\Controller;
use Model\Menu\MenuManager;
use Model\Product\ProductManager;
use Model\Translation\SystemTranslation;

class ProductController extends Controller
{

    public function productAction($uri = null)
    {
        $productManager = new ProductManager($this->getLanguage());
        $product = $productManager->getProductByUri($uri);

        $systemTranslation = new SystemTranslation($this->getLanguage());

        if ($product) {
            $title = $product->getBrand() . ' ' . $product->getName();
            $features = $productManager->getFeaturesByProduct($product->getIdProduct());
        } else {
            $title = ucfirst($systemTranslation->translate('product-not-found'));
            $features = array();
        }

        $this->template->setTitle($title);
        $this->template->addBreadcrumb('product/list', $systemTranslation->translate('product-list'));
        $this->template->addBreadcrumb('product/product/' . $uri, $title);

        $values = array(
            'product' => $product,
            'features' => $features,
            'title' => $title,
            'notFound' => $systemTranslation->translate('product-not-found-explanation')
        );

        $this->write($values);
    }
}