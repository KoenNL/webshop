<?php

namespace Controller;

use Model\User\User;
use model\user\UserManager;
use Model\Translation\SystemTranslation;
use Model\Translation\TranslationManager;

class AdminUserController extends UserController
{
    public function userAction($idUser = null)
    {
        $systemTranslation = new SystemTranslation($this->getLanguage());
        $translationManager = new TranslationManager($this->getLanguage());

        $userManager = new UserManager();
        if ($idUser) {
            $user = $userManager->getUserById($idUser);
        } else {
            $user = new User();

        }


        $error = '';

        // If the "Save" button has been used.
        if (!empty($_POST['register'])) {
            $user->setName(!empty($_POST['name']) ? $_POST['name'] : '')
                ->setEmailAddress(!empty($_POST['email-address']) ? $_POST['email-address'] : '')
                ->setPassword(!empty($_POST['password']) ? $_POST['password'] : '')
                ->setLanguage(!empty($_POST['language']) ? $_POST['language'] : '')
                ->setAddress(!empty($_POST['address']) ? $_POST['address'] : '')
                ->setPostalCode(!empty($_POST['postal-code']) ? $_POST['postal-code'] : '')
                ->setCity(!empty($_POST['city']) ? $_POST['city'] : '')
                ->setPhoneNumber(!empty($_POST['phone-number']) ? $_POST['phone-number'] : '');


            if (empty($_POST['name']) || empty($_POST['email-address']) || empty($_POST['password']) || empty($_POST['language']) || empty($_POST['address'])
                || empty($_POST['postal-code']) || empty($_POST['city']) || empty($_POST['phone-number'])
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
        $values = array(
            'user' => $user,
            'systemTranslation' => $systemTranslation,
            'languages' => $translationManager->getLanguages(),
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

        $userManager = new UserManager();
        $user = $userManager->getUserByEmailAddress($_POST);
        if(!$userManager->checkPassword($user, $_POST['password'])){
            sleep(5);
            return $this->write(array('error' => ucfirst($systemTranslation->translate('passwords-incorrect'))));
        }
        $_SESSION['user'] = $user;
        if ($user->getType() === 'admin') {
            return $this->redirect('adminorder', 'orderlist');
        }
        return $this->redirect('page', 'home');
    }

    public function userListAction()
    {
        $this->template->setTemplate('admin');

        $userManager = new UserManager($this->getLanguage());

        if (!empty($_POST['search'])) {
            $users = $userManager->getUserById($_POST['search']);
        } else {
            $users = $userManager->getUsers();
        }

        $systemTranslation = new SystemTranslation($this->getLanguage());

        $this->template->setTitle(ucfirst($systemTranslation->translate('user-list')));
        $this->template->addBreadcrumb('adminuser/userlist', ucfirst($systemTranslation->translate('user-list')));

        $values = array(
            'users' => $users,
            'noResults' => $systemTranslation->translate('no-results'),
            'search' => $systemTranslation->translate('search'),
            );

        $this->write($values);
    }
}
