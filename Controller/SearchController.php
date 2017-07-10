<?php

namespace Controller;


use Main\Controller;
use Model\Product\ProductManager;
use Model\Search\Search;
use Model\Search\SearchManager;
use Model\Translation\SystemTranslation;

class SearchController extends Controller
{

    public function searchAction()
    {
        $query = $_POST['search'];
        $productManager = new ProductManager($this->getLanguage());
        $systemTranslation = new SystemTranslation($this->getLanguage());
        $products = $productManager->getProducts($query);

        $values = array(
            'products' => $products,
            'systemTranslation' => $systemTranslation
        );

        $this->template->setTitle(ucfirst($systemTranslation->translate('search-results')));
        $this->template->addBreadcrumb('search/search', ucfirst($systemTranslation->translate('search-results')));

        if (empty($_POST['search'])) {
            $values['error'] = ucfirst($systemTranslation->translate('insert-query'));
            return $this->write($values);
        }

        $search = new Search;
        $search->setQuery($query)
            ->setTime(new \DateTime)
            ->setProducts($products);

        if (!empty($_SESSION['user'])) {
            $search->setUser($_SESSION['user']);
        }

        $searchManager = new SearchManager;
        $searchManager->save($search);

        return $this->write($values);
    }

}