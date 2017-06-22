<?php
/**
 * Created by PhpStorm.
 * User: Freek
 * Date: 8-6-2017
 * Time: 17:42
 */

namespace Controller;


class AdminUserController extends UserController
{
    public function userListAction()
    {
        $userManager = new UserManager();
        $usermanager->getUsers();

        $systemTranslation = new SystemTranslation($this->getLanguage());

        $values=array(
            'idUser' => $idUser,
            'name' => $name,
            'systemTranslation'=>$systemTranslation
            );
        return $this->write($values);
    }

}