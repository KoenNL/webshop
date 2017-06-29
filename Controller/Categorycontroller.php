<?php

namespace Controller;

use Main\Controller;

class CategoryController extends Controller
{
    public function productListAction()
    {
        $this->template->setTitle('Categorie');
        return $this->write(array());
    }
}