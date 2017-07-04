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
        if ($user->getIdUser()) {
            return $this->update($user);
        }
        return $this->insert($user);
    }

    public function archive(User $user)
    {
        $user->setActive(false);
        return $this->update($user);

    }

    public function getUsers()
    {
        $sql = 'SELECT * 
          FROM `User`';

        $users = array();

        $statement = Database::query($sql);
        // Return a mutiple user
        while ($user = Database::fetchObject($statement, 'Model\\User\\User')) {
            $users[] = $user;
        }

        return $users;
    }

    /**
     * @param int $idUser
     * @return User
     */
    public function getUserByid($idUser)
    {
        $sql = 'SELECT *
        FROM `User`
        WHERE `idUser` = :idUser';

        $parameters = array(
            'idUser' => $idUser
        );

        $statement = Database::query($sql, $parameters);

        // Return a single user
        return Database::fetchObject($statement, 'Model\\User\\User');
    }

    /**
     * @param string $emailAddress
     * @return User
     */
    public function getUserByEmailAddress($emailAddress)
    {
        $sql = 'SELECT * 
        FROM `User`
        WHERE `emailAddress` = :emailAddress';

        $parameters = array(
            'emailAddress' => $emailAddress
        );

        $statement = Database::query($sql, $parameters);

        //Return a single emailAddress
        return Database::fetchObject($statement, 'Model\\User\\User');
    }

    /**
     * Check if the given password is valid.
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function checkPassword(User $user, $password)
    {
        return password_verify($password, $user->getPassword());
    }

    private function insert(User $user) {
        $sql = 'INSERT INTO `User`(`idUser`,`idLanguage`,`name`,`emailAddress`,`password`,`type`,`address`,`postalCode`,`city`,`phoneNumber`,`active`)
                VALUES (:idUser,:idLanguage,:name,:emailAddress,:password,:type,:address,:postalCode,:city,:phoneNumber,:active)';
        $parameters = array(
            'idUser'=> $user->getIdUser(),
            'idLanguage' => $user->getLanguage(),
            'name' => $user->getName(),
            'emailAddress' => $user->getEmailAddress(),
            'type'=>$user->getType(),
            'password' => $this->passwordHash($user->getPassword()),
            'address' => $user->getAddress(),
            'postalCode' => $user->getPostalCode(),
            'city' => $user->getCity(),
            'phoneNumber' => $user->getPhoneNumber(),
            'active' => $user->getActive()

        );
        $statement = Database::query($sql, $parameters);
        $idUser = Database::getLastInsertId();
        if (!$idUser) {
            return false;
        }
        $user->setIdUser($idUser);
        return true;
    }
    private function isHashed($password) {
        $passwordInfo = password_get_info($password);
        if ($passwordInfo['algoName'] === 'unknown'){
            return false;
        }
        return true;
    }
    private function passwordHash($password) {
        if (!$this->isHashed($password)) {
            return password_hash($password, PASSWORD_BCRYPT);
        }
        return $password;
    }
    private function update(User $user) {
        $sql = 'UPDATE `User` SET
                `idUser` = :idUser,
                `idLanguage` = :idLanguage,
                `name`= :name,
                `emailAddress` = :emailAddress,
                `type` = :type,
                `password` = :password,
                `address` = :address,
                `postalCode` = :postalCode,
                `city` = :city
                `phoneNumber` = :phoneNumber,
                `active` = :active 
                WHERE `idUser` = :idUser ';
        $parameters = array(
            'idUser'=>$user->getIdUser(),
            'idLanguage' => $user->getLanguage(),
            'name' => $user->getName(),
            'emailAddress' => $user->getEmailAddress(),
            'type'=>$user->getType(),
            'password' => $this->passwordHash($user->getPassword()),
            'address' => $user->getAddress(),
            'postalCode'=> $user->getPostalCode(),
            'city' => $user->getCity(),
            'phoneNumber'=> $user->getPhoneNumber(),
            'active' => $user->getActive()
        );
        database::query($sql,$parameters);
        return true;
    }
}



// private insert V
// private update V
// archief actief true or false V
// login active or not. V
// passwordhash php validate password V
