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
     * @param string $idLanguage
     */
    public function __construct($idLanguage)
    {
        $this->idLanguage = $idLanguage;
    }

    /**
     * Get all languages from the database.
     * @return array
     */
    public function getLanguages()
    {
        $statement = Database::query('SELECT * FROM `Language`');

        $languages = array();

        while($language = Database::fetch($statement)) {
            $languages[] = $language;
        }

        return $languages;
    }

    /**
     * Get a single Translation.
     * @param int $idTranslation
     * @param string|null $idLanguage Optional language. Default language will be used if not set.
     * @return object
     */
    public function getTranslation($idTranslation, $idLanguage = null)
    {
        $sql = 'SELECT * FROM `Translation` WHERE `idTranslation` = :idTranslation AND `idLanguage` = :idLanguage';
        $parameters = array(
            'idTranslation' => $idTranslation,
            'idLanguage' => !empty($idLanguage) ? $idLanguage : $this->idLanguage
        );

        $statement = Database::query($sql, $parameters);

        return Database::fetchObject($statement, 'Model\\Translation\\Translation');
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

            $statement = Database::query($sql, $parameters);

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

        $statement = Database::query($sql, $parameters);

        return (int) $id;
    }
}
