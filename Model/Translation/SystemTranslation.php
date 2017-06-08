<?php

namespace Model\Translation;

use Main\Config;

class SystemTranslation
{
    /**
     * @var string
     */
    private $language;
    /**
     * A list of all system translations.
     * @var array
     */
    private $translations = array(
        'new-product' => array(
            'en' => 'new product',
            'nl' => 'nieuw product'
        ),
        'no-results' => array(
            'en' => 'there are no results',
            'nl' => 'er zijn geen resultaten'
        ),
        'product-not-found' => array(
            'en' => 'product not found',
            'nl' => 'product niet gevonden'
        ),
        'product-not-found-explanation' => array(
            'en' => 'Unfortunately the requested product could not be found.',
            'nl' => 'Helaas is het door u gezochte product niet gevonden.'
        ),
        'product-list' => array(
            'en' => 'product list',
            'nl' => 'productlijst'
        ),
        'save' => array(
            'en' => 'save',
            'nl' => 'opslaan'
        ),
        'search' => array(
            'en' => 'search',
            'nl' => 'zoeken'
        )
    );

    /**
     * SystemTranslation constructor.
     * @param string $language
     */
    public function __construct($language)
    {
        $this->language = $language;
    }

    /**
     * Get a translation from the given keyword in the set language.
     * If no translation is found in the set language it will return the translation in the default language.
     * If the default language has no translation the keyword is returned.
     * @param string $keyword
     * @return string
     */
    public function translate($keyword)
    {
        if (!empty($this->translations[$keyword]) && $this->language && !empty($this->translations[$keyword][$this->language])) {
            return $this->translations[$keyword][$this->language];
        } elseif (!empty($this->translations[$keyword]) && !empty($this->translations[$keyword][Config::getValue('defaultLanguage')])) {
            return $this->translations[$keyword][Config::getValue('translation.defaultLanguage')];
        }

        return str_replace('-', ' ', $keyword);
    }
}