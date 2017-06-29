<?php

namespace Controller;


use Main\Controller;

class AdminSearchController extends Controller
{

    public function searchListAction()
    {
        $this->template->setTemplate('admin');
        $this->template->setTitle('Zoekopdrachten');
        return $this->write(array());
    }

    public function searchResultsAction()
    {
        $this->template->setTemplate('admin');
        $this->template->setTitle('Zoekresultaat');
        $this->template->addBreadcrumb('/adminsearch/searchlist', 'zoekopdrachten');
        $this->template->addBreadcrumb('/adminsearch/searchresults', 'zoekresultaat');
        return $this->write(array());
    }
}