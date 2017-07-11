<?php

namespace Controller;

use Main\Controller;
use Model\Category\CategoryManager;
use Model\Product\ProductManager;
use Model\Translation\SystemTranslation;

class CategoryController extends Controller
{
    public function productListAction($idCategory = null)
    {
        if (!$idCategory) {
            return $this->redirect('page', 'home');
        }

        $categoryManager = new CategoryManager($this->getLanguage());
        $category = $categoryManager->getCategoryById($idCategory);

        if (!$category) {
            return $this->redirect('page', 'home');
        }

        $featureValues = array();

        if (!empty($_GET['features'])) {
            foreach ($_GET['features'] as $idFeature => $feature) {
                foreach($feature as $idFeatureValue => $featureValue)
                $featureValues[(int) $idFeature][] = (int)$idFeatureValue;
            }
        }

        $productManager = new ProductManager($this->getLanguage());
        $products = $productManager->getProducts(null, $idCategory, $featureValues);

        $features = $productManager->getFeatures(true);

        if ($category->getParentCategory()) {
            $this->template->setTitle(ucfirst($category->getParentCategory()->getName()) . ' - ' . ucfirst($category->getName()));
            $this->template->addBreadcrumb('category/productlist/' . $category->getParentCategory()->getIdCategory(), $category->getParentCategory()->getName());
        } else {
            $this->template->setTitle(ucfirst($category->getName()));
        }
        $this->template->addBreadcrumb('category/productlist/' . $idCategory, $category->getName());

        $values = array(
            'systemTranslation' => new SystemTranslation($this->getLanguage()),
            'category' => $category,
            'products' => $products,
            'features' => $features,
            'featureValues' => $featureValues
        );

        return $this->write($values);
    }
}