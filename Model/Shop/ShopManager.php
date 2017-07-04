<?php

namespace Model\Shop;

use Main\Database;

class ShopManager
{

    /**
     * @param $idShop
     * @return Shop
     */
    public function getShopById($idShop)
    {
        $sql = 'SELECT * FROM `Shop` WHERE `idShop` = :idShop';

        $statement = Database::query($sql, array('idShop' => $idShop));

        return Database::fetchObject($statement, 'Model\\Shop\\Shop');
    }

}