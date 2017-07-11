<?php

namespace Controller;

use Model\Category\Category;
use Model\Category\CategoryManager;
use Model\Product\Feature;
use Model\Product\FeatureValue;
use Model\Product\Product;
use Model\Product\ProductManager;
use Model\Translation\SystemTranslation;
use Model\Translation\Translation;
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
        $this->template->setTemplate('admin');
        $productManager = new ProductManager($this->getLanguage());

        $categoryManager = new CategoryManager($this->getLanguage());

        $systemTranslation = new SystemTranslation($this->getLanguage());

        $translationManager = new TranslationManager($this->getLanguage());

        if ($idProduct) {
            $product = $productManager->getProductById($idProduct);
            $this->template->setTitle($product->getBrand() . ' ' . $product->getName()->getTranslation());
        } else {
            $product = new Product();
            $this->template->setTitle(ucfirst($systemTranslation->translate('new-product')));
        }

        $error = '';

        // If the "Save" button has been used.
        if (!empty($_POST['save'])) {
            $product->setBrand(!empty($_POST['brand']) ? $_POST['brand'] : '')
                ->setActive(true)
                ->setCombinationDiscount(!empty($_POST['combination_discount']))
                ->setLanguage(!empty($_POST['language']) ? $_POST['language'] : '')
                ->setPrice(!empty($_POST['price']) ? $_POST['price'] : '');

            // Create an URI for a new product.
            if (!$product->getIdProduct()) {
                $name = new Translation;
                $name->setTranslation(!empty($_POST['name']) ? $_POST['name'] : '')
                    ->setIdLanguage(!empty($_POST['language']) ? $_POST['language'] : '');
                $description = new Translation;
                $description->setTranslation(!empty($_POST['description']) ? $_POST['description'] : '')
                    ->setIdLanguage(!empty($_POST['language']) ? $_POST['language'] : '');
                $product->setInsertDate(new DateTime())
                    ->setName($name)
                    ->setDescription($description);
                $product->setUri($productManager->createUri($product));
            } else {
                $product->getName()->setTranslation(!empty($_POST['name']) ? $_POST['name'] : '')
                    ->setIdLanguage(!empty($_POST['language']) ? $_POST['language'] : '');
                $product->getDescription()->setTranslation(!empty($_POST['brand']) ? $_POST['brand'] : '')
                    ->setIdLanguage(!empty($_POST['brand']) ? $_POST['brand'] : '');
            }

            if (!empty($_POST['categories'])) {
                foreach ($_POST['categories'] as $idCategory) {
                    $category = new Category;
                    $category->setIdCategory($idCategory);
                    $product->addCategory($category);
                }
            }

            $features = !empty($_POST['features']) ? $_POST['features'] : array();

            if (empty($_POST['brand']) || empty($_POST['name']) || empty($_POST['price']) || empty($_POST['language'])) {
                $error = $systemTranslation->translate('required-values-missing');
            }

            if (!$error) {
                // Save the product and all variations if there is no error set.
                if ($productManager->save($product, $features)) {
                    // Redirect to the product list.
                    return $this->redirect('adminproduct', 'productlist');
                }
                $error = $systemTranslation->translate('failed-to-save');
            }
        }

        $values = array(
            'product' => $product,
            'features' => $productManager->getFeatures(),
            'categories' => $categoryManager->getCategories(),
            'systemTranslation' => $systemTranslation,
            'languages' => $translationManager->getLanguages(),
            'error' => $error
        );

        return $this->write($values);
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
            $values = array('message' => $systemTranslation->translate('invalid-value'));
            return $this->write($values, 400);
        }

        $idFeature = (int)$_POST['idFeature'];

        $productManager = new ProductManager($this->getLanguage());

        $feature = $productManager->getFeatureById($idFeature);

        $feature->setFeatureValues($productManager->getFeatureValuesByFeature($idFeature));

        return $this->write(array('feature' => $feature));
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

    /**
     * @return mixed
     */
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

        $translation = new Translation;
        $translation->setIdLanguage($this->getLanguage())
            ->setTranslation($_POST['name']);

        $feature->setName($translation);

        if (!$productManager->saveFeature($feature)) {
            return $this->write(array('message' => $systemTranslation->translate('failed-to-save')), 422);
        }

        return $this->write(array('feature' => $feature));
    }

}
