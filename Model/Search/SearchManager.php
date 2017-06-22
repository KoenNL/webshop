<?php

/**
 * Created by PhpStorm.
 * User: Arie Schouten
 * Date: 21-6-2017
 * Time: 20:54
 */
class SearchManager
{
    /**
     * save Search
     */
    public function save(Search $search)
    {
        if ($search->getId()) {
            return $this->update($search);
        }
        return $this->insert($search);
    }

    public function getSearchByid($idSearch)
    {
        $sql = 'SELECT *
        FROM `Search`
        WHERE `idSearch` = :idSearch';

        $parameters = array(
            'idSearch' => $idSearch
        );

        Database::query($sql, $parameters);

        // Return a single user
        return Database::fetchObject('Model\\Search\\Search');
    }

    /**
     * @return array
     */
    public function getSearches()
    {
        $sql = 'SELECT * 
          FROM `Search`';

        $users = array();

        Database::query($sql);
        // Return a mutiple user
        while ($search = Database::fetchObject('Model\\Search\\Search')) {
            $searches[] = $search;
        }

        return $searches;
    }
    public function getSearchResults($idSearch)
    {
        $sql = 'SELECT * 
        FROM `Search`
        WHERE `idSearch` = :idSearch';

        $parameters = array(
            'idSearch' => $idSearch
        );

        Database::query($sql, $parameters);

        //Return a single emailAddress
        return Database::fetchObject('Model\\Search\\Search');
    }
    private function insert(Search $search) {
        $sql = 'INSERT INTO `search`(`idSearch`,`idUser`,`query`,`time`)
                VALUES (:idSearch,:idUser,:query,:time)';
        $parameters = array(
            'idSearch' => $search->getSearch(),
            'idUser' => $search->getUser(),
            'query' => $search->getQuery(),
            'time' => $search->getTime(),

        );
        /**
         * is dit nodig Koen wat hieronder staat eerste deel?
         */
        Database::query($sql, $parameters);
        $idSearch = Database::getLastInsertId();
        if (!$idSearch) {
            return false;
        }
        $idSearch->setIdUser($idSearch);
        return true;
    }
    private function update(Search $search) {
        $sql = 'UPDATE `search` SET
                `idSearch` = :idSearch,
                `idUser` = :idUser,
                `query` = :query,
                `time` = :TIME';
        $parameters = array(
            'idSearch' => $search->getSearch(),
            'idUser' => $search->getUser(),
            'query' => $search->getQuery(),
            'time' => $search->getTime(),
        );
        database::query($sql,$parameters);
        return true;
    }
}