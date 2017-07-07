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


class AdminSearchController extends Controller
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