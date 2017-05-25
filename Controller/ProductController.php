<?php

namespace Controller;

use Main\Controller;
use Model\Menu\MenuManager;
use Model\Product\ProductManager;

class ProductController extends Controller
{
    public function listAction()
    {
        $productList = ProductManager::getList();

        $this->template->setHeader($this->renderView(array('menu' => MenuManager::getFrontendMenu()), 'Menu/Frontend'));
        $this->write(array('productList' => $productList));
    }
}