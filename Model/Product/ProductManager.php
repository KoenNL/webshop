<?php

namespace Model\Product;

use Exception;
use Main\Config;
use Main\Database;
use Main\Format;
use Model\Image\ImageManager;
use Model\Translation\Translation;
use Model\Translation\TranslationManager;

class ProductManager
{

    /**
     * @var int
     */
    private $language;

    /**
     * ProductManager constructor.
     * @param int $language
     */
    public function __construct($language)
    {
        $this->language = $language;
    }

    /**
     * Get an array of Product objects.
     * @param int|null $idCategory
     * @param array|null $featureValues
     * @return array Array of Product objects
     */
    public function getProducts($idCategory = null, array $featureValues = null)
    {
        // Get the basic product SQL
        $productSql = $this->getProductSql();

        $sql = $productSql['sql'];

        $parameters = array();

        $whereSet = false;

        // If any of the parameters are set, start preparing WHERE statements.
        if (!empty($idCategory) || !empty($featureValues)) {
            $sql .= ' WHERE ';

            // Set WHERE statements to search for a category.
            if (!empty($idCategory)) {
                $sql .= '`ProductCategory`.`idCategory` = :idCategory ';
                $parameters['idCategory'] = (int)$idCategory;
                $whereSet = true;
            }

            // Set WHERE statements to search for feature values.
            if (!empty($featureValues)) {
                foreach ($featureValues as $key => $featureValue) {
                    if ($whereSet) {
                        $sql .= ' AND ';
                    }
                    $sql .= '`FeatureValue`.`idFeatureValue` = :featureValue' . $key;
                    $parameters['featureValue' . $key] = (int)$featureValue;
                }
            }
        }

        if (!$whereSet) {
            $sql .= ' WHERE ';
        }

        // Set the language for the correct translations.
        $sql .= $productSql['where'];
        $parameters['idLanguage'] = $this->language;
        $parameters['active'] = true;

        Database::query($sql, $parameters);

        $products = $this->fetchProducts($sql, $parameters);

        return $products;
    }

    /**
     * Get an array of products based on a name.
     * @param string $name
     * @return array An array of Product objects.
     * @throws Exception
     */
    public function getProductsByName($name)
    {
        if (empty($name) || !is_string($name)) {
            throw new Exception('Invalid value ' . $name . ' set for name in ' . __METHOD__);
        }
        // Get the basic product SQL
        $productSql = $this->getProductSql();

        $sql = $productSql['sql'];

        $sql .= 'WHERE `NameTranslation`.`translation` = :name AND ' . $productSql['where'];

        $parameters = array(
            'name' => $name,
            'idLanguage' => $this->language,
            'active' => true
        );

        $products = $this->fetchProducts($sql, $parameters);

        return $products;
    }

    /**
     * Get a Product based on the id.
     * @param int $idProduct
     * @return Product|null
     * @throws Exception
     */
    public function getProductById($idProduct)
    {
        if (empty($idProduct) || !is_numeric($idProduct)) {
            throw new Exception('Invalid value ' . $idProduct . ' set for idProduct in ' . __METHOD__);
        }
        // Get the basic product SQL
        $productSql = $this->getProductSql();

        $sql = $productSql['sql'];

        $sql .= 'WHERE `Product`.`idProduct` = :idProduct AND ';

        $sql .= $productSql['where'];

        $parameters = array(
            'idProduct' => (int)$idProduct,
            'active' => true,
            'idLanguage' => $this->language
        );

        $products = $this->fetchProducts($sql, $parameters);

        return !empty($products[0]) ? $products[0] : null;
    }

    /**
     * Get a Product based on the URI.
     * @param string $uri
     * @return Product|null
     * @throws Exception
     */
    public function getProductByUri($uri)
    {
        if (empty($uri) || !is_string($uri)) {
            return null;
        }
        // Get the basic product SQL
        $productSql = $this->getProductSql();

        $sql = $productSql['sql'];

        $sql .= 'WHERE `Product`.`uri` = :uri AND ' . $productSql['where'];

        $parameters = array(
            'uri' => $uri,
            'idLanguage' => $this->language,
            'active' => true
        );

        $products = $this->fetchProducts($sql, $parameters);

        return !empty($products[0]) ? $products[0] : null;
    }

    /**
     * Get an array with the newest products.
     * @param int $limit The limit of the amount of returned Product objects.
     * @return array An array of Product objects.
     * @throws Exception
     */
    public function getNewProducts($limit)
    {
        if (empty($limit) || !is_numeric($limit)) {
            throw new Exception('Invalid value ' . $limit . ' set for limit in ' . __METHOD__);
        }

        $productSql = $this->getProductSql();

        $sql = $productSql['sql'] . ' WHERE ' . $productSql['where'];

        $sql .= ' ORDER BY `Product`.`insertDate` ASC LIMIT :limit';

        $parameters = array(
            'limit' => $limit,
            'active' => true,
            'idLanguage' => $this->language
        );

        return $this->fetchProducts($sql, $parameters);
    }

    /**
     * Save a new, or an existing Product to the database.
     * @param Product $product
     * @param array $features
     * @return bool
     */
    public function save(Product $product, array $features)
    {
        if ($product->getIdProduct()) {
            return $this->update($product, $features);
        }
        return $this->insert($product, $features);
    }


    public function archive(Product $product)
    {
        $product->setActive(false);
        return $this->update($product);
    }

    /**
     * Create a new friendly URI form a product brand and name.
     * Also checks if the resulting URI already exists and changes it if it does.
     * @param Product $product
     * @return string The resulting URI.
     */
    public function createUri(Product $product)
    {
        $uri = Format::toUri($product->getBrand() . '-' . $product->getName());

        if ($this->getProductByUri($uri)) {
            // If it already exists check for an incrementing number...
            $increment = substr($uri, strrpos($uri, '-'));
            if (is_numeric($increment)) {
                // ... and add by 1
                $uri = str_replace('-' . $increment, '-' . ($increment + 1), $uri);
            } else {
                // ... or create an increment.
                $uri .= '-1';
            }
            // Try to create the URI again.
            return $this->createUri($uri);
        }

        return $uri;
    }

    /**
     * Get a single Feature by id.
     * @param $idFeature
     * @return Feature
     */
    public function getFeatureById($idFeature)
    {
        $sql = 'SELECT * FROM `Feature` 
            JOIN `Translation` ON `Feature`.`name` = `Translation`.`idTranslation`
            WHERE `Feature`.`idFeature` = :idFeature
            AND `Translation`.`idLanguage` = :idLanguage';
        $parameters = array(
            'idFeature' => $idFeature,
            'idLanguage' => $this->language
        );

        Database::query($sql, $parameters);

        $featureRow = Database::fetch();

        $translation = new Translation;
        $translation->setIdLanguage($this->language)
            ->setIdTranslation($featureRow['idTranslation'])
            ->setTranslation($featureRow['translation']);
        $feature = new Feature;
        $feature->setIdFeature($featureRow['idFeature'])
            ->setName($translation);

        return $feature;
    }

    /**
     * Get all FeatureValues by the given id feature.
     * @param int $idFeature
     * @return array An array with FeatureValue objects.
     */
    public function getFeatureValuesByFeature($idFeature)
    {
        $sql = 'SELECT * FROM `FeatureValue` WHERE `idFeature` = :idFeature';
        $parameters = array('idFeature' => $idFeature);

        Database::query($sql, $parameters);

        $featureValues = array();

        while ($featureValue = Database::fetchObject('Model\\Product\\FeatureValue')) {
            $featureValues[] = $featureValue;
        }

        return $featureValues;
    }

    /**
     * Save a new FeatureValue.
     * @param FeatureValue $featureValue
     * @return bool True on success or false on failure.
     */
    public function saveFeatureValue(FeatureValue $featureValue)
    {
        $sql = 'INSERT INTO `FeatureValue` (`idFeature`, `value`) VALUES(:idFeature, :value)';
        $parameters = array(
            'idFeature' => $featureValue->getIdFeature(),
            'value' => $featureValue->getValue()
        );

        Database::query($sql, $parameters);

        $idFeatureValue = Database::getLastInsertId();

        if (!$idFeatureValue) {
            return false;
        }

        $featureValue->setIdFeatureValue($idFeatureValue);

        return true;
    }

    /**
     * Save a new Feature.
     * @param Feature $feature
     * @return bool True on success or false on failure.
     * @throws Exception
     */
    public function saveFeature(Feature $feature)
    {
        $sql = 'INSERT INTO `Translation` (`translation`, `idLanguage`) VALUES(:name, :idLanguage)';
        $parameters = array(
            'name' => $feature->getName(),
            'idLanguage' => $this->language
        );

        Database::query($sql, $parameters);

        $idTranslation = Database::getLastInsertId();

        if (!$idTranslation) {
            return false;
        }

        $sqlFeature = 'INSERT INTO `Feature` (`name`) VALUES(:name)';
        $featureParameters = array('name' => $idTranslation);

        try {
            Database::query($sqlFeature, $featureParameters);
        } catch (Exception $e) {
            if (Config::getValue('debug')) {
                throw new Exception($e->getMessage());
            }
            return false;
        }

        $idFeature = Database::getLastInsertId();

        if (!$idFeature) {
            return false;
        }

        $feature->setIdFeature($idFeature);

        return true;
    }

    /**
     * Get an array of all the features.
     * @return array An array of Feature objects.
     */
    public function getFeatures()
    {
        $sql = 'SELECT * FROM `Feature`
            JOIN `Translation` ON `Feature`.`name` = `Translation`.`idTranslation`
            ORDER BY `Translation`.`translation`';

        Database::query($sql);

        $features = array();

        while ($featureRow = Database::fetch()) {
            $features[] = $this->arrayToFeature($featureRow);
        }

        return $features;
    }

    /**
     * Convert an array to a Feature object.
     * @param array $featureRow
     * @return Feature
     */
    private function arrayToFeature(array $featureRow)
    {
        $translation = new Translation;
        $translation->setIdLanguage($this->language)
            ->setIdTranslation($featureRow['idTranslation'])
            ->setTranslation($featureRow['translation']);
        $feature = new Feature;
        $feature->setIdFeature($featureRow['idFeature'])
            ->setName($translation);

        return $feature;
    }

    private function getProductSql()
    {
        $sql = 'SELECT `Product`.`idProduct`, `Product`.`brand`, `Product`.`combinationDiscount`, `Product`.`insertDate`, 
            `Product`.`uri`, `Product`.`active`, `NameTranslation`.`translation` AS `translationName`, 
            `NameTranslation`.`idTranslation` AS `idTranslationName`,
            `DescriptionTranslation`.`translation` AS `translationDescription`, `DescriptionTranslation`.`idTranslation` AS `idTranslationDescription`, 
            `FeatureTranslation`.`translation` AS `featureName`, `FeatureTranslation`.`idTranslation` AS `idFeatureName`,
            `FeatureValue`.`value` AS `featureValue`,
            `Variation`.* 
            FROM `Product` 
            JOIN `ProductCategory` ON `Product`.`idProduct` = `ProductCategory`.`idProduct`
            JOIN `Category` ON `ProductCategory`.`idCategory` = `Category`.`idCategory`
            JOIN `Variation` ON `Product`.`idProduct` = `Variation`.`idProduct`
            LEFT JOIN `VariationFeatureValue` ON `Variation`.`idVariation` = `VariationFeatureValue`.`idVariation`
            LEFT JOIN `FeatureValue` ON `VariationFeatureValue`.`idFeatureValue` = `FeatureValue`.`idFeatureValue`
            LEFT JOIN `Feature` ON `FeatureValue`.`idFeature` = `Feature`.`idFeature`
            JOIN `Translation` AS `NameTranslation` ON `Product`.`name` = `NameTranslation`.`idTranslation`
            LEFT JOIN `Translation` AS `DescriptionTranslation` ON `Product`.`description` = `DescriptionTranslation`.`idTranslation`
            LEFT JOIN `Translation` AS `FeatureTranslation` ON `Feature`.`name` = `FeatureTranslation`.`idTranslation`';

        $where = '`NameTranslation`.`idLanguage` = :idLanguage
            AND (`DescriptionTranslation`.`idLanguage` = :idLanguage OR `DescriptionTranslation`.`idLanguage` IS NULL)
            AND (`FeatureTranslation`.`idLanguage` = :idLanguage OR `FeatureTranslation`.`idLanguage` IS NULL)
            AND `Product`.`active` = :active';

        return array('sql' => $sql, 'where' => $where);
    }

    private function fetchProducts($sql, array $parameters = null)
    {
        Database::query($sql, $parameters);

        $products = array();
        $variations = array();

        $key = 1;
        $rowCount = Database::getRowCount();

//        echo '<pre>';
//        var_dump(Database::fetchAll());
//        echo '</pre>';
//exit;
        while ($product = Database::fetch()) {
            if (!empty($currentId) && $currentId !== $product['idProduct']) {
                $product['variations']  = $variations;
                $products[] = $this->arrayToProduct($product);
            }
            $currentId = $product['idProduct'];
            $variations[] = $this->arrayToVariation($product);

            if ($key === $rowCount) {
                // Also add the last product to the list.
                $product['variations']  = $variations;
                $products[] = $this->arrayToProduct($product);
            }
            $key++;
        }

        return $products;
    }

    private function arrayToProduct(array $productArray)
    {
        $product = new Product;

        $product->setIdProduct($productArray['idProduct'])
            ->setBrand($productArray['brand'])
            ->setCombinationDiscount($productArray['combinationDiscount'])
            ->setInsertDate($productArray['insertDate'])
            ->setUri($productArray['uri'])
            ->setActive($productArray['active'])
            ->setVariations($productArray['variations']);

        // Turn the name into a Translation.
        $name = new Translation;
        $name->setIdLanguage($product->getLanguage())
            ->setIdTranslation($productArray['idTranslationName'])
            ->setTranslation($productArray['translationName']);

        // Turn the description into a Translation.
        $description = new Translation;
        $description->setIdLanguage($product->getLanguage())
            ->setIdTranslation($productArray['idTranslationDescription'])
            ->setTranslation($productArray['translationDescription']);

        $product->setName($name)
            ->setDescription($description);

        return $product;
    }

    private function arrayToVariation(array $variationArray)
    {
        $variation = new Variation;
        $variation->setIdVariation($variationArray['idVariation'])
            ->setPrice($variationArray['price'])
            ->setStock($variationArray['stock']);

        $imageManager = new ImageManager($this->language);
        //$images = $imageManager->getImagesByVariation($variation->getIdVariation());

//        $variation->setImages($images);

        return $variation;
    }

    private function insert(Product $product, array $features)
    {
        $translationManager = new TranslationManager($this->language);

        $idNameTranslation = $translationManager->save($product->getName()->getTranslation());
        if ($product->getDescription()) {
            $idDescriptionTranslation = $translationManager->save($product->getDescription()->getTranslation());
        }

        $sql = 'INSERT INTO `Product` (`brand`, `name`, `description`, `combinationDiscount`, `insertDate`, `URI`, `active`) 
            VALUES(:brand, :name, :description, :combinationDiscount, :insertDate, :URI, :active)';

        $parameters = array(
            'brand' => $product->getBrand(),
            'name' => $idNameTranslation,
            'description' => $idDescriptionTranslation,
            'combinationDiscount' => $product->getCombinationDiscount(),
            'insertDate' => $product->getInsertDate()->format('Y-m-d H:i:s'),
            'URI' => $product->getUri(),
            'active' => $product->getActive()
        );

        Database::query($sql, $parameters);

        $idProduct = Database::getLastInsertId();

        if (!$idProduct) {
            return false;
        }

        $product->setIdProduct($idProduct);

        $this->saveCategories($product);
        $this->createVariations($product, $features);

        return true;
    }

    private function update(Product $product, array $features = null)
    {
        $sql = 'UPDATE `Product` 
            SET `brand` = :brand, 
            `combinationDiscount` = :combinationDiscount, 
            `URI` = :URI, 
            `active` = :active
            WHERE `idProduct` = :idProduct';
        $parameters = array(
            'brand' => $product->getBrand(),
            'combinationDiscount' => $product->getCombinationDiscount(),
            'URI' => $product->getUri(),
            'active' => $product->getActive(),
            'idProduct' => $product->getIdProduct()
        );

        Database::query($sql, $parameters);

        $translationManager = new TranslationManager($this->language);

        // Save the translations.
        $translationManager->save($product->getName()->getTranslation(), $product->getName()->getIdTranslation());
        $translationManager->save($product->getDescription()->getTranslation(), $product->getDescription()->getIdTranslation());

        return true;
    }

    /**
     * Create new variations and add them to the existing ones.
     * @param array $features
     * @param array $variations
     * @return array
     */
    private function addFeatures(array $features, array $variations)
    {
        $result = array();
        $variationKey = 0;
        foreach ($variations as $variation) {
            foreach ($features as $feature) {
                $result[$variationKey] = $variation;
                $result[$variationKey][] = $feature;
                $variationKey++;
            }
        }

        return $result;
    }

    /**
     * Create variations for every combination of every feature.
     * @param Product $product
     * @param array $features
     * @return bool
     */
    private function createVariations(Product $product, array $features)
    {
        if (!$features) {
            $variations = array(0);
        } else {
            $variations = array();
        }

        // Go through every feature.
        foreach ($features as $key => $feature) {
            $feature = array_keys($feature);
            // If no variations are present create the array with the current feature values.
            if (!$variations) {
                foreach ($feature as $variation) {
                    $variations[] = array($variation);
                }
            } else {
                $variations = $this->addFeatures($feature, $variations);
            }
        }

        $variationSql = 'INSERT INTO `Variation` (`idProduct`, `price`, `stock`, `tax`) 
            VALUES(:idProduct, :price, :stock, :tax)';

        $variationFeatureValueSql = 'INSERT INTO `VariationFeatureValue` VALUES(:idVariation, :idFeatureValue)';

        // This array is generated by the form's POST
        foreach ($variations as $variation) {
            $variationParameters = array(
                'idProduct' => $product->getIdProduct(),
                'price' => $product->getPrice(),
                // Temporary values of 0 for stock and tax. Will be used in a future version.
                'stock' => 0,
                'tax' => 0.00
            );

            // Save the variation.
            Database::query($variationSql, $variationParameters);

            $idVariation = Database::getLastInsertId();

            if (!$idVariation) {
                return false;
            }

            $this->saveImages($product, $idVariation);


            // Save all relations between the variation and it's feature values.
            foreach ($variation as $idFeatureValue) {
                if ($idFeatureValue === 0) {
                    continue;
                }
                $variationFeatureValueParameters = array(
                    'idVariation' => $idVariation,
                    'idFeatureValue' => $idFeatureValue
                );

                Database::query($variationFeatureValueSql, $variationFeatureValueParameters);
            }
        }

        return true;
    }

    /**
     * Save all categories.
     * @param Product $product
     * @return bool True on success or false on failure.
     */
    private function saveCategories(Product $product)
    {
        $sql = 'INSERT INTO `ProductCategory` VALUES(:idProduct, :idCategory)';
        $parameters = array('idProduct' => $product->getIdProduct());
        foreach ($product->getCategories() as $category) {
            $parameters['idCategory'] = $category->getIdCategory();

            Database::query($sql, $parameters);
        }

        return true;
    }

    /**
     * Save all images.
     * @param Product $product
     * @param $idVariation
     * @return bool True on success or false on failure.
     */
    private function saveImages(Product $product, $idVariation)
    {
        $sql = 'INSERT INTO `VariationImage` VALUES(:idVariation, :idImage)';
        $parameters = array('idVariation' => $idVariation);
        foreach ($product->getImages() as $image) {
            $parameters['idImage'] = $image->getIdImage();

            Database::query($sql, $parameters);
        }

        return true;
    }
}
