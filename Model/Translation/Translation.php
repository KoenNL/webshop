<?php

namespace Model\Translation;


class Translation implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idLanguage;
    /**
     * @var int
     */
    private $idTranslation;
    /**
     * @var string
     */
    private $translation;

    /**
     * @param string $idLanguage
     * @return Translation $this
     */
    public function setIdLanguage($idLanguage)
    {
        $this->idLanguage = $idLanguage;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdLanguage()
    {
        return $this->idLanguage;
    }

    /**
     * @param int $idTranslation
     * @return Translation $this
     */
    public function setIdTranslation($idTranslation)
    {
        $this->idTranslation = (int) $idTranslation;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdTranslation()
    {
        return $this->idTranslation;
    }

    /**
     * @param string $translation
     * @return Translation $this
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * @return string
     */
    public function JSONSerialize()
    {
        return $this->translation;
    }

    /**
     * Return the translation as a string.
     * @return string
     */
    public function __toString()
    {
        return $this->translation;
    }
}