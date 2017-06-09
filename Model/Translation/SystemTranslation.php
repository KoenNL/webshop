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
        'add-feature' => array(
            'en' => 'add feature',
            'nl' => 'kenmerk toevoegen'
        ),
        'back-to-summary' => array(
            'en' => 'back to summary',
            'nl' => 'terug naar overzicht'
        ),
        'brand' => array(
            'en' => 'brand',
            'nl' => 'merk'
        ),
        'categories' => array(
            'en' => 'categories',
            'nl' => 'categorie&euml;n'
        ),
        'close' => array(
            'en' => 'close',
            'nl' => 'sluiten'
        ),
        'combination-discount' => array(
            'en' => 'combination discount',
            'nl' => 'combinatiekorting'
        ),
        'description' => array(
            'en' => 'description',
            'nl' => 'omschrijving'
        ),
        'edit' => array(
            'en' => 'edit',
            'nl' => 'wijzigen'
        ),
        'features' => array(
            'en' => 'features',
            'nl' => 'kenmerken'
        ),
        'general' => array(
            'en' => 'general',
            'nl' => 'algemeen'
        ),
        'images' => array(
            'en' => 'images',
            'nl' => 'afbeeldingen'
        ),
        'name' => array(
            'en' => 'name',
            'nl' => 'naam'
        ),
        'new-product' => array(
            'en' => 'new product',
            'nl' => 'nieuw product'
        ),
        'no-results' => array(
            'en' => 'there are no results',
            'nl' => 'er zijn geen resultaten'
        ),
        'price' => array(
            'en' => 'price',
            'nl' => 'prijs'
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
        ),
        'select' => array(
            'en' => 'select',
            'nl' => 'selecteren'
        ),
        'to-variations' => array(
            'en' => 'to variations',
            'nl' => 'naar variaties'
        ),
        'upload' => array(
            'en' => 'upload',
            'nl' => 'uploaden'
        ),
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