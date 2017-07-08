<?php
namespace Model\Search;


/**
 * Created by PhpStorm.
 * User: Arie Schouten
 * Date: 18-6-2017
 * Time: 22:16
 */
class Search
{
    /**
     * @var int
     */
    private $idSearch;
    /**
     * @var int
     */
    private $idUser;
    /**
     * @var string
     */
    private $query;
    /**
     * @var datetime
     */
    private $time;

    /**
     * @param $idSearch
     * @return $this
     */
    public function setIdSearch($idSearch)
    {
    $this->idSearch =(int)$idSearch;
    return $this;
    }
    /**
     * @return int
     */
    public function getIdSearch()
    {
        return $this->idSearch;
    }

    /**
     * @param $idUser
     * @return $this
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
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query =(string)$query;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param $time
     */
    public function setTime($time)
    {
        $this->time = $time;
        /**
         *
         */
    }
    /**
     * @return datetime
     */
    public function getTime()
    {
        return $this->time;
    }
}