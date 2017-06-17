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
          FROM `User`';

        $users = array();

        Database::query($sql);
        // Return a mutiple user
        while ($user = Database::fetchObject('Model\\User\\User')) {
            $users[] = $user;
        }

        return $users;
    }


    public function getUserByid($idUser)
    {
        $sql = 'SELECT *
        FROM `User`
        WHERE `idUser` = :idUser';

        $parameters = array(
            'idUser' => $idUser
        );

        Database::query($sql, $parameters);

        // Return a single user
        return Database::fetchObject('Model\\User\\User');
    }

    public function getUserByEmailAddress($emailAddress)
    {
        $sql = 'SELECT * 
        FROM `User`
        WHERE `emailAddress` = :emailAddress';

        $parameters = array(
            'emailAddress' => $emailAddress
        );

        Database::query($sql, $parameters);

        //Return a single emailAddress
        return Database::fetchObject('Model\\User\\User');
    }
}




// private insert
// private update
// archief actief true or false
// login active or not.
// passwordhash php validate password