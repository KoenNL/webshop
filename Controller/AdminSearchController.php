<?php

/**
 * Created by PhpStorm.
 * User: Arie Schouten
 * Date: 28-6-2017
 * Time: 20:16
 */

namespace Controller;

use Main\Controller;
use Model\Translation\SystemTranslation;
use Model\Search\SearchManager;

class AdminSearchController extends Controller
{

    public function searchListAction()
    {
        $systemTranslation = new SystemTranslation($this->getLanguage());
        $this->template->setTemplate('admin');
        $this->template->setTitle(ucfirst($systemTranslation->translate('search-results')));

        $searchManager = new SearchManager($this->getLanguage());

        if (!empty($_POST['search'])) {
            $searches = $searchManager->getSearchById($_POST['search']);
        } else {
            $searches = $searchManager->getSearches();
        }
       return $this->write(array('search' => $searches));
    }

    public function searchResultsAction()
    {
        $systemTranslation = new SystemTranslation($this->getLanguage());
        $searchManager = new SearchManager($this->getLanguage());
        $this->template->setTemplate('admin');
        $this->template->setTitle(ucfirst($systemTranslation->translate('search-results')));
        $this->template->addBreadcrumb('/adminsearch/searchlist', ucfirst($systemTranslation->translate('search-query')));
        $this->template->addBreadcrumb('/adminsearch/searchresults', ucfirst($systemTranslation->translate('search-results')));

        $idSearch = $searchManager->getSearches();
        $searchManager = new SearchManager($this->getLanguage());
        $idSearch = $searchManager->getSearchResults($idSearch);
        return $this->write(array('idSearch' => $idSearch));
    }

}
