<?php

namespace Model\Search;

use Main\Database;

class SearchManager
{

    /**
     * @param Search $search
     * @return bool
     */
    public function save(Search $search)
    {
        if ($search->getIdSearch()) {
            return $this->update($search);
        }
        return $this->insert($search);
    }

    /**
     * @param int $idSearch
     * @return Search
     */
    public function getSearchById($idSearch)
    {
        $sql = 'SELECT *
        FROM `Search`
        WHERE `idSearch` = :idSearch';

        $parameters = array(
            'idSearch' => $idSearch
        );

        $statement = Database::query($sql, $parameters);

        // Return a single user
        return Database::fetchObject($statement, 'Model\\Search\\Search');
    }

    /**
     * @return array
     */
    public function getSearches()
    {
        $sql = 'SELECT * FROM `Search`';

        $searches = array();

        $statement = Database::query($sql);
        // Return multiple searches
        while ($search = Database::fetchObject($statement, 'Model\\Search\\Search')) {
            $searches[] = $search;
        }

        return $searches;
    }

    /**
     * @param int $idSearch
     * @return object
     */
    public function getSearchResults($idSearch)
    {
        $sql = 'SELECT * 
        FROM `Search`
        WHERE `idSearch` = :idSearch';

        $parameters = array(
            'idSearch' => $idSearch
        );

        $statement = Database::query($sql, $parameters);

        //Return a single emailAddress
        return Database::fetchObject($statement, 'Model\\Search\\Search');
    }

    /**
     * @param Search $search
     * @return bool
     */
    private function insert(Search $search) {
        $sql = 'INSERT INTO `Search`(`idUser`,`query`,`time`)
                VALUES (:idUser,:query,:time)';
        $parameters = array(
            'idUser' => $search->getUser() ? $search->getUser()->getIdUser() : null,
            'query' => $search->getQuery(),
            'time' => $search->getTime()->format('Y-m-d H:i:s'),
        );

        Database::query($sql, $parameters);
        $idSearch = Database::getLastInsertId();

        if (!$idSearch) {
            return false;
        }

        $search->setIdSearch($idSearch);

        $this->insertSearchResults($search);

        return true;
    }

    /**
     * @param Search $search
     * @return bool
     */
    private function update(Search $search) {
        $sql = 'UPDATE `Search` SET
                `idUser` = :idUser,
                `query` = :query,
                `time` = :time
                WHERE `idSearch` = :idSearch';
        $parameters = array(
            'idSearch' => $search->getIdSearch(),
            'idUser' => $search->getUser() ? $search->getUser()->getIdUser() : '',
            'query' => $search->getQuery(),
            'time' => $search->getTime()->format('Y-m-d H:i:s'),
        );
        Database::query($sql,$parameters);
        return true;
    }

    /**
     * @param Search $search
     * @return bool
     */
    private function insertSearchResults(Search $search)
    {
        if (!$search->getIdSearch()) {
            return false;
        }
        $sql = 'INSERT INTO `SearchResult` VALUES(:idSearch, :idProduct)';

        $parameters = array('idSearch' => $search->getIdSearch());

        foreach ($search->getProducts() as $product) {
            $parameters['idProduct'] = $product->getIdProduct();
            Database::query($sql, $parameters);
        }

        return true;
    }

}