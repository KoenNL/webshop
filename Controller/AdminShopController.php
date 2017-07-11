<?php

namespace Controller;

use Main\Controller;

class AdminShopController extends Controller
{
    public function settingsAction()
    {
        $this->template->setTemplate('admin');
        return $this->write(array());
    }
}