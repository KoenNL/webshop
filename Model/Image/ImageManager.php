<?php

namespace Model\Image;

use Main\Database;

class ImageManager
{
    /**
     * @var int
     */
    private $idLanguage;

    /**
     * ImageManager constructor.
     * @param int $idLanguage
     */
    public function __construct($idLanguage)
    {
        $this->idLanguage = (int)$idLanguage;
    }

    /**
     * Get an array with Image objects that belong to the given idVariation.
     * @param int $idVariation
     * @return array Array with Image objects.
     */
    public function getImagesByVariation($idVariation)
    {
        $sql = 'SELECT * FROM `Image` 
        JOIN `Translation` ON `Image`.`name` = `Translation`.`idTranslation`
        JOIN `VariationImage` ON `Image`.`idImage` = `VariationImage`.`idImage`
        WHERE `VariationImage`.`idVariation` = :idVariation
        AND `Translation`.`idLanguage` = :idLanguage
        ORDER BY `idOriginalImage`';

        $parameters = array(
            'idVariation' => (int)$idVariation,
            'idLanguage' => $this->idLanguage
        );

        Database::query($sql, $parameters);

        $images = array();
        $originalImage = null;

        while ($image = Database::fetch()) {
            if (empty($image['idOriginalImage'])) {
                $originalImage = $this->arrayToImage($image);
                continue;
            }
            if ($originalImage) {
                $image['idOriginalImage'] = $originalImage;
            }

            $images[] = $this->arrayToImage($image);
        }

        return $images;
    }

    /**
     * Convert an array to an Image object.
     * @param array $imageArray
     * @return Image
     */
    private function arrayToImage(array $imageArray)
    {
        $image = new Image;

        $image->setIdImage($imageArray['idImage'])
            ->setName($imageArray['translation'])
            ->setPath($imageArray['path'])
            ->setSize($imageArray['size']);

        if (!empty($imageArray['originalImage'])) {
            $image->setOriginalImage($imageArray['originalImage']);
        }

        return $image;
    }
}