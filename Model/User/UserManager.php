<?php
/**
 * Created by PhpStorm.
 * User: Arie Schouten
 * Date: 8-6-2017
 * Time: 11:49
 */

namespace model\user;


use Main\Database;

class UserManager
{
    public function save(User $user)
    {
        if ($user->getId()) {
            return $this->insert($user);
        }
        return $this->update($user);
    }

    public function archive(user $user)
    {
    }

    public function getUsers()
    {
        $sql = 'SELECT * 
          FROM `users`';

        $users = array();

        Database::query($sql);
        while ($user = Database::fetchObject('Model\\User\\User')) {
            $users[] = $user;
        }
        return $users;
    }
}
{
    public function getUserByid(idUser)
{
    if (empty$idUser) || !is_numeric(idUser) {
        throw new \Exception('Invalid vanlue' . $idUser . ' set for idUser in ' .__METHOD__);

        }
}

    }
// private insert
// private

