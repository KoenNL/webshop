<?php

namespace Controller;

use Main\Config;
use Main\Controller;
use Model\Shop\ShopManager;
use Model\User\User;
use Model\user\UserManager;
use Model\Translation\TranslationManager;
use Model\Translation\SystemTranslation;

class UserController extends Controller
{

    public function userAction($idUser = null)
    {
        $userManager = new UserManager();
        if ($idUser) {
            $user = $userManager->getUserById($idUser);
        } else {
            $user = new User();
            $user->setActive(true);
        }
        $systemTranslation = new SystemTranslation($this->getLanguage());
        $translationManager = new TranslationManager($this->getLanguage());

        $error = '';

        if (!empty($_SESSION['user'])) {
            $this->template->setTitle(ucfirst($systemTranslation->translate('my-data')));
        } else {
            $this->template->setTitle(ucfirst($systemTranslation->translate('register')));
        }

        // If the "Save" button has been used.
        if (!empty($_POST['save'])) {
            $user->setName(!empty($_POST['name']) ? $_POST['name'] : '')
                ->setEmailAddress(!empty($_POST['email-address']) ? $_POST['email-address'] : '')
                ->setPassword(!empty($_POST['password']) ? $_POST['password'] : '')
                ->setLanguage(!empty($_POST['language']) ? $_POST['language'] : '')
                ->setAddress(!empty($_POST['address']) ? $_POST['address'] : '')
                ->setPostalCode(!empty($_POST['postal-code']) ? $_POST['postal-code'] : '')
                ->setCity(!empty($_POST['city']) ? $_POST['city'] : '')
                ->setPhoneNumber(!empty($_POST['phone-number']) ? $_POST['phone-number'] : '')
                ->setType(!empty($_POST['type']) ? $_POST['type'] : '');


            if (empty($_POST['name']) || empty($_POST['email-address']) || empty($_POST['password']) || empty($_POST['language']) || empty($_POST['address'])
                || empty($_POST['postal-code']) || empty($_POST['city'])
            ) {
                $error = $systemTranslation->translate('required-values-missing');
            } elseif ($_POST['password'] !== $_POST['password-repeat']) {
                $error = $systemTranslation->translate('passwords-do-not-match');
            }

            if (!$error) {
                // Save the user if there is no error set.
                if ($userManager->save($user)) {
                    // Redirect to home
                    return $this->redirect('page', 'home');
                }
                $error = $systemTranslation->translate('failed-to-save');
            }

        }

        $shopManager = new ShopManager();
        $shop = $shopManager->getShopById(Config::getValue('idShop'));

        $values = array(
            'user' => $user,
            'systemTranslation' => $systemTranslation,
            'languages' => $translationManager->getLanguages(),
            'idLanguage' => $shop->getIdLanguage(),
            'error' => $error
        );

        return $this->write($values);
    }

    public function changePasswordAction($idUser)
    {

        $systemTranslation = new SystemTranslation($this->getLanguage());

        $userManager = new UserManager();
        if ($idUser) {
            $user = $userManager->getUserById($idUser);
        } else {
            return $this->write(array('error' => ucfirst($systemTranslation->translate('user-not-found'))));

        }

        $currentPassword = $_POST['current-password'];
        if (!$userManager->checkPassword($user, $currentPassword)) {
            return $this->write(array('error' => ucfirst($systemTranslation->translate('password-incorrect'))));
        }

        $password = $_POST['password'];
        $passwordRepeat = $_POST['password-repeat'];
        if ($password <> $passwordRepeat) {
            return $this->write(array('error' => ucfirst($systemTranslation->translate('passwords-do-not-match'))));
        }

        $user->setPassword($password);
        $userManager->save($user);

        return $this->write(array('info' => ucfirst($systemTranslation->translate('password-changed'))));
    }

    public function loginAction()
    {
        $systemTranslation = new SystemTranslation($this->getLanguage());
        $this->template->setTemplate('plain');
        $userManager = new UserManager();
        $user = $userManager->getUserByEmailAddress(!empty($_POST['login-email-address']) ? $_POST['login-email-address'] : null);

        $this->template->setTitle(ucfirst($systemTranslation->translate('login')));

        $values = array(
            'systemTranslation' => $systemTranslation
        );

        if ((empty($_POST['login-email-address']) && !$user)
            || (!empty($_POST['login-email-address']) && $user && !$userManager->checkPassword($user, $_POST['login-password']))
        ) {
            sleep(3);
            $values['error'] = ucfirst($systemTranslation->translate('password-email-incorrect'));
            return $this->write($values);
        }
        $_SESSION['user'] = $user;

        if ($user->getType() === 'admin') {
            return $this->redirect('adminorder', 'orderlist');
        }

        // Redirect according to the referrer.
        switch ($this->getReferrer()) {
            case 'order/cart':
                return $this->redirect('order', 'summary');
            default:
                return $this->redirectURL($_SERVER['HTTP_REFERER']);
        }

        return $this->write($values);
    }

    public function logOffAction()
    {
        if (empty($_SESSION['user'])) {
            $this->redirect('page', 'home');
        }

        unset($_SESSION['user']);

        return $this->redirect('page', 'home');
    }

}
