<?php

namespace Model\Menu;

class MenuManager
{
    public static function getFrontendMenu()
    {
        $menu = array(
            'herenmode',
            'damesmode',
            'tienermode'
        );

        return $menu;
    }
}