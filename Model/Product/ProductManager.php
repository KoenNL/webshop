<?php

namespace Model\Product;

use Exception;
use Main\Config;
use Main\Database;
use Main\Format;
use Model\Category\Category;
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
     * @param array|null $features
     * @return array Array of Product objects
     */
    public function getProducts($search = null, $idCategory = null, array $features = null)
    {
        // Get the basic product SQL
        $productSql = $this->getProductSql();

        $sql = $productSql['sql'];

        $parameters = array();

        $whereSet = false;

        // If any of the parameters are set, start preparing WHERE statements.
        if (!empty($search) || !empty($idCategory) || !empty($features)) {
            $sql .= ' WHERE ';

            // Set WHERE statements to search for a search query.
            if (!empty($search)) {
                $sql .= '(`Product`.`brand` LIKE :search OR `NameTranslation`.`translation` LIKE :search) ';
                $parameters['search'] = '%' . $search . '%';
                $whereSet = true;
            }

            // Set WHERE statements to search for a category.
            if (!empty($idCategory)) {
                if ($whereSet) {
                    $sql .= ' AND ';
                }
                $sql .= '`ProductCategory`.`idCategory` = :idCategory ';
                $parameters['idCategory'] = (int)$idCategory;
                $whereSet = true;
            }

            // Set WHERE statements to search for feature values.
            if (!empty($features)) {
                if ($whereSet) {
                    $sql .= ' AND ';
                }
                $featureTotal = count($features);
                $featureCount = 1;
                foreach ($features as $idFeature => $featureValues) {
                    $featureValueTotal = count($featureValues);
                    $featureValueCount = 1;
                    $sql .= '(';
                    foreach ($featureValues as $key => $featureValue) {
                        $sql .= '`FeatureValue`.`idFeatureValue` = :featureValue' . $key;
                        $parameters['featureValue' . $key] = (int)$featureValue;

                        if ($featureValueCount < $featureValueTotal) {
                            $sql .= ' OR ';
                        }

                        $featureValueCount++;
                    }
                    $sql .= ')';
                    if ($featureCount < $featureTotal) {
                        $sql .= ' AND ';
                    }

                    $featureCount++;
                }
                $whereSet = true;
            }
        }

        if (!$whereSet) {
            $sql .= ' WHERE ';
        } else {
            $sql .= ' AND ';
        }

        // Set the language for the correct translations.
        $sql .= $productSql['where'];
        $sql .= ' ORDER BY `Product`.`idProduct`';
        $parameters['idLanguage'] = $this->language;
        $parameters['active'] = true;

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

        $sql .= ' AND `Product`.`idProduct` ORDER BY `Product`.`insertDate` DESC';

        $parameters = array(
            'active' => true,
            'idLanguage' => $this->language
        );

        return $this->fetchProducts($sql, $parameters, $limit);
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

        $statement = Database::query($sql, $parameters);

        $featureRow = Database::fetch($statement);

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

        $statement = Database::query($sql, $parameters);

        $featureValues = array();

        while ($featureValue = Database::fetchObject($statement, 'Model\\Product\\FeatureValue')) {
            $featureValues[] = $featureValue;
        }

        return $featureValues;
    }

    /**
     * Get all FeatureValues by the given id variation.
     * @param int $idVariation
     * @return array An array with FeatureValue objects.
     */
    public function getFeatureValuesByVariation($idVariation)
    {
        $sql = 'SELECT * FROM `FeatureValue` 
          JOIN `VariationFeatureValue` ON `FeatureValue`.`idFeatureValue` = `VariationFeatureValue`.`idFeatureValue`
          WHERE `VariationFeatureValue`.`idVariation` = :idVariation';
        $parameters = array('idVariation' => $idVariation);

        $statement = Database::query($sql, $parameters);

        $featureValues = array();

        while ($featureValue = Database::fetchObject($statement, 'Model\\Product\\FeatureValue')) {
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

        $statement = Database::query($sql, $parameters);

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

        $statement = Database::query($sql, $parameters);

        $idTranslation = Database::getLastInsertId();

        if (!$idTranslation) {
            return false;
        }

        $sqlFeature = 'INSERT INTO `Feature` (`name`) VALUES(:name)';
        $featureParameters = array('name' => $idTranslation);

        try {
            $statement = Database::query($sqlFeature, $featureParameters);
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
     * @param bool $getFeatureValues
     * @return array An array of Feature objects.
     */
    public function getFeatures($getFeatureValues = false)
    {
        $sql = 'SELECT * FROM `Feature`
            JOIN `Translation` ON `Feature`.`name` = `Translation`.`idTranslation`
            ORDER BY `Translation`.`translation`';

        $statement = Database::query($sql);

        $features = array();

        $key = 0;

        while ($featureRow = Database::fetch($statement)) {
            $features[$key] = $this->arrayToFeature($featureRow);

            if ($getFeatureValues) {
                $features[$key]->setFeatureValues($this->getFeatureValuesByFeature($featureRow['idFeature']));
            }

            $key++;
        }

        return $features;
    }

    /**
     * @param int $idVariation
     * @return Variation
     */
    public function getVariationById($idVariation)
    {
        $sql = 'SELECT * FROM `Variation` WHERE `idVariation` = :idVariation';

        $parameters = array(
            'idVariation' => $idVariation
        );

        $statement = Database::query($sql, $parameters);

        return Database::fetchObject($statement, 'Model\\Product\\Variation');
    }

    /**
     * Get a variation that belongs to the given product and has the given features.
     * @param $idProduct
     * @param array $features
     * @return Variation
     */
    public function getVariationByFeatures($idProduct, array $features)
    {
        if (!$features) {
            return null;
        }

        $sql = 'SELECT `Variation`.* FROM `Variation`';
        $parameters = array('idProduct' => $idProduct);
        foreach ($features as $idFeature => $idFeatureValue) {
            $sql .= ' JOIN `VariationFeatureValue` AS `VariationFeatureValue' . $idFeature . '` 
                ON `Variation`.`idVariation` = `VariationFeatureValue' . $idFeature . '`.`idVariation`
                AND `VariationFeatureValue' . $idFeature . '`.`idFeatureValue` = :idFeatureValue' . $idFeature;
            $parameters['idFeatureValue' . $idFeature] = $idFeatureValue;
        }
        $sql .= ' WHERE `Variation`.`idProduct` = :idProduct';

        $statement = Database::query($sql, $parameters);

        return Database::fetchObject($statement, 'Model\\Product\\Variation');
    }

    /**
     * Get a product by it's variation.
     * @param int $idVariation
     * @return Product|null
     */
    public function getProductByVariation($idVariation)
    {
        $productSql = $this->getProductSql();

        $sql = $productSql['sql'] . ' WHERE ' . $productSql['where'];

        $sql .= ' AND `Variation`.`idVariation` = :idVariation';

        $parameters = array(
            'idLanguage' => $this->language,
            'active' => true,
            'idVariation' => $idVariation
        );

        $result = $this->fetchProducts($sql, $parameters);

        $product = !empty($result) ? $result[0] : null;

        if (!$product) {
            return null;
        }

        $variation = $this->getVariationById($idVariation);
        $variation->setFeatureValues($this->getFeatureValuesByVariation($idVariation));

        $product->setSelectedVariation($variation);

        return $product;
    }


    public function getFeaturesByProduct($idProduct)
    {
        $sql = 'SELECT * FROM `Feature`
          JOIN `FeatureValue` ON `Feature`.`idFeature` = `FeatureValue`.`idFeature`
          JOIN `Translation` ON `Feature`.`name` = `Translation`.`idTranslation`
          JOIN `VariationFeatureValue` ON `FeatureValue`.`idFeatureValue` = `VariationFeatureValue`.`idFeatureValue`
          JOIN `Variation` ON `VariationFeatureValue`.`idVariation` = `Variation`.`idVariation`
          WHERE `Variation`.`idProduct` = :idProduct
          GROUP BY `FeatureValue`.`idFeatureValue`';

        $parameters = array(
            'idProduct' => $idProduct
        );

        $statement = Database::query($sql, $parameters);

        $features = array();

        while ($feature = Database::fetch($statement)) {
            if (empty($features[$feature['idFeature']])) {
                $translation = new Translation;
                $translation->setIdLanguage($this->language)
                    ->setIdTranslation($feature['idTranslation'])
                    ->setTranslation($feature['translation']);
                $features[$feature['idFeature']] = new Feature;
                $features[$feature['idFeature']]->setIdFeature($feature['idFeature'])
                    ->setName($translation);
            }

            $featureValue = new FeatureValue;
            $featureValue->setIdFeature($feature['idFeature'])
                ->setIdFeatureValue($feature['idFeatureValue'])
                ->setValue($feature['value']);

            $features[$feature['idFeature']]->addFeatureValue($featureValue);
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
            `FeatureValue`.`value` AS `featureValue`, `CategoryTranslation`.`translation` AS `categoryTranslation`,
            `CategoryTranslation`.`idTranslation` AS `idCategoryTranslation`, `Category`.`idCategory`, `Category`.`position`,
            `NameTranslation`.`idLanguage`,
            `Variation`.* 
            FROM `Product` 
            JOIN `ProductCategory` ON `Product`.`idProduct` = `ProductCategory`.`idProduct`
            JOIN `Category` ON `ProductCategory`.`idCategory` = `Category`.`idCategory`
            JOIN `Variation` ON `Product`.`idProduct` = `Variation`.`idProduct`
            LEFT JOIN `VariationFeatureValue` ON `Variation`.`idVariation` = `VariationFeatureValue`.`idVariation`
            LEFT JOIN `FeatureValue` ON `VariationFeatureValue`.`idFeatureValue` = `FeatureValue`.`idFeatureValue`
            LEFT JOIN `Feature` ON `FeatureValue`.`idFeature` = `Feature`.`idFeature`
            JOIN `Translation` AS `NameTranslation` ON `Product`.`name` = `NameTranslation`.`idTranslation`
            JOIN `Translation` AS `CategoryTranslation` ON `Category`.`name` = `CategoryTranslation`.`idTranslation`
            LEFT JOIN `Translation` AS `DescriptionTranslation` ON `Product`.`description` = `DescriptionTranslation`.`idTranslation`
            LEFT JOIN `Translation` AS `FeatureTranslation` ON `Feature`.`name` = `FeatureTranslation`.`idTranslation`';

        $where = '`NameTranslation`.`idLanguage` = :idLanguage
            AND `CategoryTranslation`.`idLanguage` = :idLanguage
            AND (`DescriptionTranslation`.`idLanguage` = :idLanguage OR `DescriptionTranslation`.`idLanguage` IS NULL)
            AND (`FeatureTranslation`.`idLanguage` = :idLanguage OR `FeatureTranslation`.`idLanguage` IS NULL)
            AND `Product`.`active` = :active';

        return array('sql' => $sql, 'where' => $where);
    }

    private function fetchProducts($sql, array $parameters = null, $limit = null)
    {
        $statement = Database::query($sql, $parameters);

        $products = array();
        $variations = array();
        $categories = array();

        $key = 1;
        $rowCount = Database::getRowCount($statement);

        while ($product = Database::fetch($statement)) {
            if (!empty($currentProduct['idProduct']) && $currentProduct['idProduct'] !== $product['idProduct']) {
                $currentProduct['variations'] = $variations;
                $currentProduct['categories'] = $categories;
                $products[] = $this->arrayToProduct($currentProduct);
                $variations = array();
                $categories = array();
            }
            $currentProduct = $product;

            if (empty($variations[$product['idVariation']])) {
                $variations[$product['idVariation']] = $this->arrayToVariation($product);
            }

            if (empty($categories[$product['idCategory']])) {
                $category = new Category;
                $categoryName = new Translation;
                $categoryName->setIdLanguage($product['idLanguage'])
                    ->setIdTranslation($product['idCategoryTranslation'])
                    ->setTranslation($product['categoryTranslation']);
                $category->setIdCategory($product['idCategory'])
                    ->setName($categoryName)
                    ->setPosition($product['position']);
                $categories[$product['idCategory']] = $category;
            }

            if ($key === $rowCount) {
                // Also add the last product to the list.
                $product['variations'] = $variations;
                $product['categories'] = $categories;
                $products[] = $this->arrayToProduct($product);
                $variations = array();
                $categories = array();
            }
            if ($limit && count($products) === $limit) {
                return $products;
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

        foreach ($productArray['variations'] as $variation) {
            $product->addVariation($variation);
        }

        foreach ($productArray['categories'] as $category) {
            $product->addCategory($category);
        }

        return $product;
    }

    private function arrayToVariation(array $variationArray)
    {
        $variation = new Variation;
        $variation->setIdVariation($variationArray['idVariation'])
            ->setPrice($variationArray['price'])
            ->setStock($variationArray['stock']);

        $imageManager = new ImageManager($this->language);
        $images = $imageManager->getImagesByVariation($variation->getIdVariation());

        $variation->setImages($images);

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

        $statement = Database::query($sql, $parameters);

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

        $statement = Database::query($sql, $parameters);

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
            $statement = Database::query($variationSql, $variationParameters);

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

                $statement = Database::query($variationFeatureValueSql, $variationFeatureValueParameters);
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

            $statement = Database::query($sql, $parameters);
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

            $statement = Database::query($sql, $parameters);
        }

        return true;
    }
}
