<?php

namespace Controller;

class AdminCategoryController extends CategoryController
{

    public function categoryListAction (){
        $this->template->setTemplate('admin');
        return $this->write(array());
    }
}