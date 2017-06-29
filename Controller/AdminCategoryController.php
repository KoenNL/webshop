<?php

namespace Controller;


use Main\Controller;

class AdminCategoryController extends Controller
{

    public function categoryListAction (){
        $this->template->setTemplate('admin');
        return $this->write(array());
    }
}