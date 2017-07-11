<?php

namespace Controller;

use Model\Translation\SystemTranslation;


class AdminSearchController extends SearchController
{

    public function searchListAction()
    {
        $systemTranslation = new SystemTranslation($this->getLanguage());
        $this->template->setTemplate('admin');
        $this->template->setTitle(ucfirst($systemTranslation->translate('search-results')));


        return $this->write(array());
    }

    public function searchResultsAction()
    {
        $systemTranslation = new SystemTranslation($this->getLanguage());
        $this->template->setTemplate('admin');
        $this->template->setTitle(ucfirst($systemTranslation->translate('search-results')));
        $this->template->addBreadcrumb('/adminsearch/searchlist', ucfirst($systemTranslation->translate('search-query')));
        $this->template->addBreadcrumb('/adminsearch/searchresults', ucfirst($systemTranslation->translate('search-results')));


        return $this->write(array());
    }



}