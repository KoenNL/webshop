<?php

namespace Controller;

use Model\Product\Product;
use Model\Product\ProductManager;
use Model\Translation\SystemTranslation;

class AdminProductController extends ProductController
{

    public function productListAction()
    {
        $this->template->setTemplate('admin');

        $productManager = new ProductManager($this->getLanguage());

        if (!empty($_POST['search'])) {
            $products = $productManager->getProductsByName($_POST['search']);
        } else {
            $products = $productManager->getProducts();
        }

        $systemTranslation = new SystemTranslation($this->getLanguage());

        $this->template->setTitle(ucfirst($systemTranslation->translate('product-list')));
        $this->template->addBreadcrumb('adminproduct/productlist', ucfirst($systemTranslation->translate('product-list')));

        $values = array(
            'products' => $products,
            'noResults' => $systemTranslation->translate('no-results'),
            'search' => $systemTranslation->translate('search'),
            'newProduct' => $systemTranslation->translate('new-product'),
        );

        $this->write($values);
    }

    public function productAction($idProduct = null)
    {
        $productManager = new ProductManager($this->getLanguage());

        $systemTranslation = new SystemTranslation($this->getLanguage());

        if ($idProduct) {
            $product = $productManager->getProductById($idProduct);
            $this->template->setTitle($product->getBrand() . ' ' . $product->getName());
        } else {
            $product = new Product();
            $this->template->setTitle(ucfirst($systemTranslation->translate('new-product')));
        }

        if (!empty($_POST['save'])) {
            $product->setBrand($_POST['brand'])
                ->setName($_POST['name']);

            $productManager->save($product);
        }

        $values = array(
            'product' => $product,
            'save' => $systemTranslation->translate('save')
        );

        $this->write($values);
    }

}