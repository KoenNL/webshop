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
        'failed-to-save' => array(
            'en' => 'failed to save value to the database',
            'nl' => 'het was niet mogelijk om de waarde op te slaan in de database'
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
        'invalid-value' => array(
            'en' => 'invalid value',
            'nl' => 'ongeldige waarde'
        ),
        'name' => array(
            'en' => 'name',
            'nl' => 'naam'
        ),
        'fatal-error' => array(
            'en' => 'a fatal error has occurred',
            'nl' => 'er heeft zich een fatale fout voorgedaan'
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
        'invalid-value' => array(
            'en' => 'invalid value',
            'nl' => 'ongeldige waarde'
        ),
        'name' => array(
            'en' => 'name',
            'nl' => 'naam'
        ),
        'new-product' => array(
            'en' => 'new product',
            'nl' => 'nieuw product'
        ),
        'new-products' => array(
            'en' => 'new products',
            'nl' => 'nieuwe producten'
        ),
        'new-value' => array(
            'en' => 'new value',
            'nl' => 'nieuwe waarde'
        ),
        'no-results' => array(
            'en' => 'there are no results',
            'nl' => 'er zijn geen resultaten'
        ),
        'price' => array(
            'en' => 'price',
            'nl' => 'prijs'
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
        'required-values-missing' => array(
            'en' => 'required value(s) are missing',
            'nl' => 'niet alle verplichte velden zijn ingevuld'
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
        'change-data' => array(
            'en' => 'change data',
            'nl' => 'gegevens wijzigen'
        ),
        'change-password' => array(
            'en' => 'change password',
            'nl' => 'wachtwoord wijzigen'
        ),
        'my-orders' => array(
            'en' => 'my orders',
            'nl' => 'mijn bestellingen'
        ),
        'password' => array(
            'en' => 'password',
            'nl' => 'wachtwoord'
        ),
        'email-address' => array(
            'en' => 'e-mail address',
            'nl' => 'e-mailadres'
        ),
        'repeat-password' => array(
            'en' => 'repeat password',
            'nl' => 'herhaal wachtwoord'
        ),
        'language' => array(
            'en' => 'language',
            'nl' => 'taal'
        ),
        'address' => array(
            'en' => 'address',
            'nl' => 'adres'
        ),
        'postal-code' => array(
            'en' => 'postal code',
            'nl' => 'postcode'
        ),
        'city' => array(
            'en' => 'city',
            'nl' => 'plaats'
        ),
        'phone-number' => array(
            'en' => 'phone number',
            'nl' => 'telefoonnummer'
        ),
        'register' => array(
            'en' => 'register',
            'nl' => 'registreer'
        ),
        'my-data' => array(
            'en' => 'my data',
            'nl' => 'mijn gegevens'
        ),
        'current-password' => array(
            'en' => 'current password',
            'nl' => 'huidig wachtwoord'
        ),
        'edit' => array(
            'en' => 'edit',
            'nl' => 'wijzigen'
        ),
        'login' => array(
            'en' => 'login',
            'nl' => 'inloggen'
        ),
        'no-account' => array(
            'en' => 'no account?',
            'nl' => 'nog geen account?'
        ),
        'type' => array(
            'en' => 'type',
            'nl' => 'type'
        ),
        'back-to-overview' => array(
            'en' => 'back to the overview',
            'nl' => 'terug naar het overzicht'
        ),
        'new-user' => array(
            'en' => 'new user',
            'nl' => 'nieuwe gebruiker'
        ),
        'actions' => array(
            'en' => 'actions',
            'nl' => 'acties'
        ),
        'delete' => array(
            'en' => 'delete',
            'nl' => 'verwijderen'
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
