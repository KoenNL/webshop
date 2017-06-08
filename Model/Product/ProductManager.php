<?php

namespace Model\Product;

use Exception;
use Main\Database;
use Model\Image\ImageManager;
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
        $this->laguage = (int)$language;
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

        Database::query($sql, $parameters);

        $products = $this->fetchProducts($sql, $parameters);

        return $products;
    }

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
            'idLanguage' => $this->language
        );

        $products = $this->fetchProducts($sql, $parameters);

        return $products;
    }

    public function getProductById($idProduct)
    {
        if (empty($idProduct) || !is_numeric($idProduct)) {
            throw new Exception('Invalid value ' . $idProduct . ' set for idProduct in ' . __METHOD__);
        }
        // Get the basic product SQL
        $productSql = $this->getProductSql();

        $sql = $productSql['sql'];

        $sql .= 'WHERE `Product`.`idProduct` = :idProduct';

        $parameters = array('idProduct' => (int)$idProduct);

        $products = $this->fetchProducts($sql, $parameters);

        return !empty($products[0]) ? $products[0] : null;
    }

    public function getProductByUri($uri)
    {
        if (empty($uri) || !is_string($uri)) {
            throw new Exception('Invalid value ' . $uri . ' set for uri in ' . __METHOD__);
        }
        // Get the basic product SQL
        $productSql = $this->getProductSql();

        $sql = $productSql['sql'];

        $sql .= 'WHERE `Product`.`uri` = :uri AND ' . $productSql['where'];

        $parameters = array(
            'uri' => $uri,
            'idLanguage' => $this->language
        );

        $products = $this->fetchProducts($sql, $parameters);

        return !empty($products[0]) ? $products[0] : null;
    }

    public function getNewProducts($limit)
    {
        if (empty($limit) || !is_numeric($limit)) {
            throw new Exception('Invalid value ' . $limit . ' set for limit in ' . __METHOD__);
        }

        $productSql = $this->getProductSql();

        $sql = $productSql['sql'];

        $sql .= 'ORDER BY `Product`.`insertDate` ASC LIMIT :limit';

        $parameters = array('limit' => $limit);

        return $this->fetchProducts($sql, $parameters);
    }

    public function save(Product $product)
    {
        if ($product->getId()) {
            return $this->insert($product);
        }

        return $this->update($product);
    }

    public function archive(Product $product)
    {

    }

    private function getProductSql()
    {
        $sql = 'SELECT `Product`.`idProduct`, `Product`.`brand`, `Product`.`combinationDiscount`, `Product`.`insertDate`, 
            `Product`.`uri`, `Product`.`active`, `NameTranslation`.`translation` AS `translationName`, 
            `DescriptionTranslation`.`translation` AS `translationDescription`, `FeatureTranslation`.`translation` AS `featureName`, 
            `Variation`.* 
            FROM `Product` 
            JOIN `ProductCategory` ON `Product`.`idProduct` = `ProductCategory`.`idCategory`
            JOIN `Category` ON `ProductCategory`.`idCategory` = `Category`.`idCategory`
            JOIN `Variation` ON `Product`.`idProduct` = `Variation`.`idProduct`
            JOIN `VariationFeatureValue` ON `Variation`.`idVariation` = `VariationFeatureValue`.`idVariation`
            JOIN `FeatureValue` ON `VariationFeatureValue`.`idFeatureValue` = `FeatureValue`.`idFeatureValue`
            JOIN `Feature` ON `FeatureValue`.`idFeature` = `Feature`.`idFeature`
            JOIN `Translation` AS `NameTranslation` ON `Product`.`name` = `NameTranslation`.`idTranslation`
            LEFT JOIN `Translation` AS `DescriptionTranslation` ON `Product`.`description` = `DescriptionTranslation`.`idTranslation`
            JOIN `Translation` AS `FeatureTranslation` ON `Feature`.`name` = `FeatureTranslation`.`idTranslation` ';

        $where = '`NameTranslation`.`idLanguage` = :idLanguage
            AND `DescriptionTranslation`.`idLanguage` = :idLanguage
            AND `FeatureTranslation`.`idLanguage` = :idLanguage ';

        return array('sql' => $sql, 'where' => $where);
    }

    private function fetchProducts($sql, array $parameters = null)
    {
        Database::query($sql, $parameters);

        $products = array();

        while ($product = Database::fetch()) {
            if (empty($currentId) || $currentId !== $product['idProduct']) {
                if (!empty($variations)) {
                    $product['variations'] = $variations;
                    $products[] = $this->arrayToProduct($product);
                }
                $currentId = $product['idProduct'];
                $variations = array();
            }
            $variations[] = $this->arrayToVariation($product);
        }

        return $products;
    }

    private function arrayToProduct(array $productArray)
    {
        $product = new Product;
        $product->setIdProduct($productArray['idProduct'])
            ->setBrand($productArray['brand'])
            ->setName($productArray['translationName'])
            ->setDescription($productArray['translationDescription'])
            ->setCombinationDiscount($productArray['combinationDiscount'])
            ->setInsertDate($productArray['insertDate'])
            ->setUri($productArray['uri'])
            ->setActive($productArray['active'])
            ->setVariations($productArray['variations']);

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

    private function insert(Product $product)
    {
        $translationManager = new TranslationManager($this->language);

        $idNameTranslation = $translationManager->save($product->getName());
        $idDescriptionTranslation = $translationManager->save($product->getDescription());

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

        return $product;
    }

    /**
     * Create variations for every combination of every feature.
     * @param Product $product
     * @param array $features
     * @return bool
     */
    private function createVariations(Product $product, array $features)
    {
        $variationSql = 'INSERT INTO `Variation` (`idProduct`, `price`, `stock`, `tax`) 
            VALUES(:idProduct, :price, :stock, :tax)';

        $variationFeatureValueSql = 'INSERT INTO `VariationFeatureValue` VALUES(:idVariation, :idFeatureValue)';

        $variations = array();

        // This array is generated by the form's POST
        foreach ($features as $idFeature => $featureValues) {
            foreach ($features as $idSecondaryFeature => $secondaryFeatureValues) {

            }
            $variationParameters = array(
                'idProduct' => $product->getIdProduct(),
                'price' => $product->getPrice(),
                // Temporary values of 0 for stock and tax. Will be used in a future version.
                'stock' => 0,
                'tax' => 0.00
            );

            Database::query($variationSql, $variationParameters);

            $idVariation = Database::getLastInsertId();

            if (!$idVariation) {
                return false;
            }

            foreach ($featureValues as $idFeatureValue) {
                $variationFeatureValueParameters = array(
                    'idVariation' => $idVariation,
                    'idFeatureValue' => $idFeatureValue
                );

                Database::query($variationFeatureValueSql, $variationFeatureValueParameters);
            }
        }

        return true;
    }
}