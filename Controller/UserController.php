<?php
/**
 * Created by PhpStorm.
 * User: Freek
 * Date: 8-6-2017
 * Time: 13:12
 */

namespace Controller;


use Main\Controller;

class UserController extends Controller
{
    public function userAction($idUser = null)
    {
    if ($idUser){
        $user = $userManager->getUserById($userId)
    } else {
        

    }
    }
}