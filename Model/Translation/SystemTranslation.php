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
        'amount' => array(
            'en' => 'amount',
            'nl' => 'aantal'
        ),
        'back-to-summary' => array(
            'en' => 'back to summary',
            'nl' => 'terug naar overzicht'
        ),
        'brand' => array(
            'en' => 'brand',
            'nl' => 'merk'
        ),
        'cart' => array(
            'en' => 'shopping cart',
            'nl' => 'winkelwagen'
        ),
        'cart-is-empty' => array(
            'en' => 'your shopping cart is empty',
            'nl' => 'uw winkelwagen is leeg'
        ),
        'categories' => array(
            'en' => 'categories',
            'nl' => 'categorie&euml;n'
        ),
        'change-cart' => array(
            'en' => 'change cart',
            'nl' => 'winkelwagen wijzigen'
        ),
        'close' => array(
            'en' => 'close',
            'nl' => 'sluiten'
        ),
        'combination-discount' => array(
            'en' => 'combination discount',
            'nl' => 'combinatiekorting'
        ),
        'continue-order' => array(
            'en' => 'continue order',
            'nl' => 'verder met bestellen'
        ),
        'continue-shopping' => array(
            'en' => 'continue shopping',
            'nl' => 'verder winkelen'
        ),
        'description' => array(
            'en' => 'description',
            'nl' => 'omschrijving'
        ),
        'edit' => array(
            'en' => 'edit',
            'nl' => 'wijzigen'
        ),
        'email-end' => array(
            'en' => 'kind regards',
            'nl' => 'met vriendelijke groet'
        ),
        'email-error' => array(
            'en' => 'an error occurred while sending an email',
            'nl' => 'er heeft zich een fout voorgedaan tijdens het versturen van een e-mail'
        ),
        'email-intro' => array(
            'en' => 'dear',
            'nl' => 'beste'
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
        'login-register' => array(
            'en' => 'login/register',
            'nl' => 'inloggen/registreren'
        ),
        'name' => array(
            'en' => 'name',
            'nl' => 'naam'
        ),
        'fatal-error' => array(
            'en' => 'a fatal error has occurred',
            'nl' => 'er heeft zich een fatale fout voorgedaan'
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
        'no-product-set' => array(
            'en' => 'no product set',
            'nl' => 'geen product gegeven'
        ),
        'order' => array(
            'en' => 'order',
            'nl' => 'bestelling'
        ),
        'order-complete' => array(
            'en' => 'order complete',
            'nl' => 'bestelling voltooid'
        ),
        'order-confirmation' => array(
            'en' => 'order confirmation',
            'nl' => 'bestelbevestiging'
        ),
        'order-confirmation-message' => array(
            'en' => 'Thank you for your order. 
            You will receive an email when your order has been sent out. We\'ll send your order as soon as possible.',
            'nl' => 'Bedankt voor uw bestlling. U krijgt nog een e-mail wanneer wij de bestelling naar u hebben verzonden. Wij sturen de bestelling zo snel
            mogelijk naar u toe.'
        ),
        'no-results' => array(
            'en' => 'there are no results',
            'nl' => 'er zijn geen resultaten'
        ),
        'search-results' => array(
            'en' => 'search results',
            'nl' => 'zoekresultaten'
        ),
        'search-query' => array(
            'en' => 'search query',
            'nl' => 'zoekopdracht'
        ),
        'payment' => array(
            'en' => 'payment',
            'nl' => 'betaling'
        ),
        'payment-error' => array(
            'en' => 'an error occurred while redirecting to the payment provider',
            'nl' => 'er is een fout ontstaan bij het doorsturen naar de betalingsservice'
        ),
        'price' => array(
            'en' => 'price',
            'nl' => 'prijs'
        ),
        'price-per-piece' => array(
            'en' => 'price per piece',
            'nl' => 'prijs per stuk'
        ),
        'product' => array(
            'en' => 'product',
            'nl' => 'product'
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
        'shipping-cost' => array(
            'en' => 'shipping cost',
            'nl' => 'verzendkosten'
        ),
        'shipping-costs-free-at' => array(
            'en' => 'shipping costs are free on an order above',
            'nl' => 'verzendkosten zijn gratis op een bestelling boven'
        ),
        'subtotal' => array(
            'en' => 'subtotal',
            'nl' => 'subtotaal'
        ),
        'summary' => array(
            'en' => 'summary',
            'nl' => 'overzicht'
        ),
        'thanks-for-your-order' => array(
            'en' => 'thanks for your order',
            'nl' => 'bedankt voor uw bestelling'
        ),
        'thanks-for-order-message' => array(
            'en' => 'Thank you for your order. You received an email with a confirmation. 
            You will also receive an email when your order has been sent out. We\'ll send your order as soon as possible.',
            'nl' => 'Bedankt voor uw bestlling. U heeft een e-mail met een bevestiging van ons ontvangen. U
            krijgt nog een e-mail wanneer wij de bestelling naar u hebben verzonden. Wij sturen de bestelling zo snel
            mogelijk naar u toe.',
        ),
        'total' => array(
            'en' => 'total',
            'nl' => 'totaal'
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
        ),
        'user-not-found' => array(
            'en' => 'user not found',
            'nl' => 'gebruiker niet gevonden'
        ),
        'password-incorrect' => array(
            'en' => 'password incorrect',
            'nl' => 'wachtwoord onjuist'
        ),
        'passwords-do-not-match' => array(
            'en' => 'passwords do not match',
            'nl' => 'wachtwoorden komen niet overeen'
        ),
        'password-email-incorrect' => array(
            'en' => 'your e-mail or password is incorrect',
            'nl' => 'uw e-mail of wachtwoord is onjuist'
        ),
        'password-changed' => array(
            'en' => 'you have succesfully changed your password',
            'nl' => 'U heeft uw wachtwoord succesvol gewijzigd'

        ),
        'view-order' => array(
            'en' => 'view order',
            'nl' => 'bestelling inzien'

        ),
        'shipping-costs' => array(
            'en' => 'shipping costs',
            'nl' => 'verzendkosten'

        ),
        'shipping-costs-threshold' => array(
            'en' => 'shipping costs threshold',
            'nl' => 'verzendkosten drempel'

        ),
        'default-combination-discount' => array(
            'en' => 'default combination discount',
            'nl' => 'standaard combinatiekorting'
        ),
        'default-tax' => array(
            'en' => 'default tax',
            'nl' => 'standaard BTW precentage'

        ),
        'default-language' => array(
            'en' => 'default language',
            'nl' => 'standaard taal'

        ),
        'go-to-results' => array(
            'en' => 'go to results',
            'nl' => 'naar resultaten'

        ),
        'go-to-user' => array(
            'en' => 'go to user',
            'nl' => 'naar gebruiker'

        ),
        'translate' => array(
            'en' => 'translate',
            'nl' => 'vertalen'

        ),
        'thanks-for-ordering' => array(
            'en' => 'thank you for ordering',
            'nl' => 'bedankt voor uw bestelling'

        ),
        'order-message' => array(
            'en' => 'thank you for ordering at Duncan&Brown. You will receive an confirmation e-mail shortly. When we have shipped your order
            we will e-mail you. Your order will be shipped as soon as possible.',
            'nl' => 'bedankt voor uw bestlling bij Duncan&Brown. U heeft een e-mail met een bevestiging van ons ontvangen. U
            krijgt nog een e-mail wanneer wij de bestelling naar u hebben verzonden. Wij sturen de bestelling zo snel
            mogelijk naar u toe.'
        ),
        'order' => array(
            'en' => 'order',
            'nl' => 'bestellingen'
        ),
        'product' => array(
            'en' => 'product',
            'nl' => 'product'
        ),
        'price-each' => array(
            'en' => 'price each',
            'nl' => 'prijs per stuk'
        ),
        'ammount' => array(
            'en' => 'ammount',
            'nl' => 'aantal'
        ),
        'subtotal' => array(
            'en' => 'subtotal',
            'nl' => 'subtotaal'
        ),
        'total' => array(
            'en' => 'total',
            'nl' => 'totaal'
        ),
        'free-shipping' => array(
            'en' => '(on orders with a total price of over &euro; 75-, shipping is free)',
            'nl' => '(bij een bestelling van meer dan &euro; 75,- zijn er geen verzendkosten)'

        ),
        'no-search-results' => array(
            'en' => 'sorry, no search results found',
            'nl' => 'sorry, geen zoekresultaat gevonden'
        ),
        'insert-query' => array(
            'en' => 'please enter a search query',
            'nl' => 'voer alstublieft een zoekopdracht in'
        ),

        'user-list' => array(
            'en' => 'user list',
            'nl' => 'gebruikerslijst'
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
