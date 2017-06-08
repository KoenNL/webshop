<?php
/**
 * Created by PhpStorm.
 * User: Freek
 * Date: 8-6-2017
 * Time: 13:12
 */

namespace Controller;


use Main\Controller;
use Model\User\User;
use model\user\UserManager;

class UserController extends Controller
{
    public function userAction($idUser = null)
    {

        $userManager = new UserManager();
        if ($idUser) {
            $user = $userManager->getUserById($idUser);
        } else {
            $user = new User();

        }
    }

    public function changePasswordAction($idUser)
    {
        $userManager = new UserManager();
        if ($idUser) {
            $user = $userManager->getUserById($idUser);
        } else {
            return $this->write(array('error' => 'Gebruiker niet gevonden'));

        }

        $currentPassword = $_POST['current-password'];
        if (!$userManager->checkPassword($user, $currentPassword)) {
            return $this->write(array('error' => 'Wachtwoord onjuist.'));
        }

        $password = $_POST['password'];
        $passwordRepeat = S_POST['password-repeat'];
        if ($password <> $passwordRepeat) {
            return $this->write(array('error' => 'Wachtwoorden komen niet overeen.'));
        }

        $user->setPassword($password);
        $userManager->save($user);

        return $this->write(array('info' => 'U heeft uw wachtwoord succesvol gewijzigd.'));
    }

    public function loginAction()
    {
        $userManager = new UserManager();
                 $user = $userManager->getUserByEmailAddress($_POST);
         if(!$userManager->checkPassword($user, $_POST['password'])){
             sleep(5);
              return $this->write(array('error' => 'Uw e-mail of wachtwoord is onjuist.'));
        }
        $_SESSION['idUser']=$user->getIdUser();


        if ($user->getType()==='admin'){
            return $this->redirect('adminorder', 'orderlist');
        }
        return $this->redirect('page', 'home');
    }

}