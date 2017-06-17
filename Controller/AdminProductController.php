<?php

namespace Controller;

use Model\Product\Feature;
use Model\Product\FeatureValue;
use Model\Product\Product;
use Model\Product\ProductManager;
use Model\Translation\SystemTranslation;
use Model\Translation\TranslationManager;
use \Datetime;

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

        $translationManager = new TranslationManager($this->getLanguage());

        if ($idProduct) {
            $product = $productManager->getProductById($idProduct);
            $this->template->setTitle($product->getBrand() . ' ' . $product->getName());
        } else {
            $product = new Product();
            $this->template->setTitle(ucfirst($systemTranslation->translate('new-product')));
        }

        $error = false;

        // If the "Save" button has been used.
        if (!empty($_POST['save'])) {
            $product->setBrand($_POST['brand'])
                ->setName($_POST['name'])
                ->setActive(true)
                ->setCombinationDiscount($_POST['combination_discount'])
                ->setLanguage($_POST['language'])
                ->setDescription($_POST['description'])
                ->setPrice($_POST['price']);

            // Create an URI for a new product.
            if (!$product->getIdProduct()) {
                $product->setUri($productManager->createUri($product))
                    ->setInsertDate(new DateTime());
            }

            // Save the product and all variations.
            if ($productManager->save($product)) {
                // Redirect to the product list.
                return $this->redirect('adminproduct', 'productlist');
            }
            $error = true;
        }

        $values = array(
            'product' => $product,
            'systemTranslation' => $systemTranslation,
            'languages' => $translationManager->getLanguages(),
            'error' => $error
        );

        $this->write($values);
    }

    /**
     * A JSON action to get all feature values based on the id of a feature.
     * @return mixed
     */
    public function getFeatureValuesAction()
    {
        // Force a JSON extension since this is going to be used for AJAX requests only.
        $this->setExtension('json');

        $systemTranslation = new SystemTranslation($this->getLanguage());

        if (empty($_POST['idFeature']) || !is_numeric($_POST['idFeature'])) {
            return $this->write(array('message' => $systemTranslation->translate('invalid-value')), 400);
        }

        $idFeature = (int)$_POST['idFeature'];

        $productManager = new ProductManager($this->getLanguage());

        $featureValues = $productManager->getFeatureValuesByFeature($idFeature);

        return $this->write(array('featureValues' => $featureValues));
    }

    /**
     * A JSON action to get all feature values based on the id of a feature.
     * @return mixed
     */
    public function addFeatureValueAction()
    {
        // Force a JSON extension since this is going to be used for AJAX requests only.
        $this->setExtension('json');

        $systemTranslation = new SystemTranslation($this->getLanguage());

        if (empty($_POST['idFeature']) || !is_numeric($_POST['idFeature']) || empty($_POST['value'])) {
            return $this->write(array('message' => $systemTranslation->translate('invalid-value')), 400);
        }

        $productManager = new ProductManager($this->getLanguage());

        $featureValue = new FeatureValue;

        $featureValue->setIdFeature($_POST['idFeature'])
            ->setValue($_POST['value']);

        if (!$productManager->saveFeatureValue($featureValue)) {
            return $this->write(array('message' => $systemTranslation->translate('failed-to-save')), 422);
        }

        return $this->write(array('featureValue' => $featureValue));
    }

    public function addFeatureAction()
    {
        // Force a JSON extension since this is going to be used for AJAX requests only.
        $this->setExtension('json');

        $systemTranslation = new SystemTranslation($this->getLanguage());

        if (empty($_POST['name'])) {
            return $this->write(array('message' => $systemTranslation->translate('invalid-value')), 400);
        }

        $productManager = new ProductManager($this->getLanguage());

        $feature = new Feature;

        $feature->setName($_POST['name']);

        if (!$productManager->saveFeature($feature)) {
            return $this->write(array('message' => $systemTranslation->translate('failed-to-save')), 422);
        }

        return $this->write(array('feature' => $feature));
    }

}