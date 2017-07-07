<?php
<<<<<<< HEAD
=======
/**
 * Created by PhpStorm.
 * User: Arie Schouten
 * Date: 28-6-2017
 * Time: 20:16
 */
>>>>>>> arie

namespace Controller;


<<<<<<< HEAD
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
=======
class AdminSearchController
{

>>>>>>> arie
}