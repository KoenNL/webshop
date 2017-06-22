<?php
namespace Model\User;

use Model\Product\Variation;

/**
 * Created by PhpStorm.
 * User: Freek
 * Date: 8-6-2017
 * Time: 11:30
 */
class User
{
    /**
     * @var int
     */
    private $idUser;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $emailAddress;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $address;
    /**
     * @var string
     */
    private $postalCode;
    /**
     * @var string
     */
    private $city;
    /**
     * @var string
     */
    private $phoneNumber;
    /**
     * @var array
     */
    private $wishes = array();
    /**
     * @var string
     */
    private $language;
    /**
     * @var bool
     */
    private $active;

    /**
     * @param int $idUser
     * @return User $this
     */
    public function setIdUser($idUser)
    {
        $this->idUser = (int)$idUser;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $emailAddress
     * @return User $this
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param string $password
     * @return User $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $type
     * @return User $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $address
     * @return User $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**\
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $postalCode
     * @return User $this
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $city
     * @return User $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $phoneNumber
     * @return User $this
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param Variation $wish
     * @return User $this
     */
    public function addWish(Variation $wish)
    {
        $this->wishes[] = $wish;
        return $this;

    }
    /**
     * @param array $wishes
     * @return $this
     */
    public function setWishes(array $wishes)
    {
        foreach ($wishes as $wish) {
            $this->addWish($wish);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getWishes()
    {
        return $this->wishes;
    }

    /**
     * @param string $language
     * @return User $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param bool $active
     * @return User $this
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;
        return $this;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

}