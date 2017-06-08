<?php

namespace Model\Translation;

use Main\Database;

class TranslationManager
{
    /**
     * @var int
     */
    private $idLanguage;

    /**
     * TranslationManager constructor.
     * @param int $idLanguage
     */
    public function __construct($idLanguage)
    {
        $this->idLanguage = (int)$idLanguage;
    }

    /**
     * Save a new translation or update an existing one.
     * @param int $translation
     * @param null $id
     * @return int The id of the inserted or updated translation.
     */
    public function save($translation, $id = null)
    {
        if (!$id) {
            $sql = 'INSERT INTO `Translation` (`idLanguage`, `translation`) VALUES(:idLanguage, :translation)';

            $parameters = array(
                'idLanguage' => $this->idLanguage,
                'translation' => $translation
            );

            Database::query($sql, $parameters);

            return Database::getLastInsertId();
        }

        $sql = 'UPDATE `Translation` SET `translation` = :translation 
        WHERE `idTranslation` = :idTranslation
        AND `idLanguage` = :idLanguage';

        $parameters = array(
            'idLanguage' => $this->idLanguage,
            'translation' => $translation,
            'idTranslation' => $id
        );

        Database::query($sql, $parameters);

        return (int) $id;
    }
}