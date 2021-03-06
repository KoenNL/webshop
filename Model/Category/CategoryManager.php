<?php

namespace Model\Category;


use Main\Database;
use Model\Translation\Translation;

class CategoryManager
{

    private $idLanguage;

    public function __construct($idLanguage)
    {
        $this->idLanguage = $idLanguage;
    }

    /**
     * Get an array of categories sorted by position.
     * @return array An array of Category objects.
     */
    public function getCategories()
    {
        $categorySql = $this->getCategorySql();

        $sql = $categorySql['sql'] . ' WHERE ' . $categorySql['where'] . ' ORDER BY `positionOrder`';

        $parameters = array(
            'active' => true,
            'idLanguage' => $this->idLanguage
        );

        $statement = Database::query($sql, $parameters);

        $categories = array();
        $parentCategory = new Category;

        while ($categoryRow = Database::fetch($statement)) {
            if (empty($categoryRow['idParentCategory']) && $parentCategory->getIdCategory() != $categoryRow['idCategory']) {
                $parentCategory = $this->arrayToCategory($categoryRow);
                $categories[] = $parentCategory;
            } elseif (!empty($categoryRow['idParentCategory'])) {
                $categories[] = $this->arrayToCategory($categoryRow, $parentCategory);
            }
        }

        return $categories;
    }

    /**
     * @param int $idCategory
     * @return Category
     */
    public function getCategoryById($idCategory)
    {
        $categorySql = $this->getCategorySql();

        $sql = $categorySql['sql'] . ' WHERE ' . $categorySql['where'] . ' AND `Category`.`idCategory` = :idCategory';

        $parameters = array(
            'active' => true,
            'idLanguage' => $this->idLanguage,
            'idCategory' => $idCategory
        );

        $statement = Database::query($sql, $parameters);

        $categoryRow = Database::fetch($statement);

        $translation = new Translation;
        $translation->setIdLanguage($this->idLanguage)
            ->setIdTranslation($categoryRow['idTranslation'])
            ->setTranslation($categoryRow['translation']);

        $category = new Category;
        $category->setIdCategory($categoryRow['idCategory'])
            ->setName($translation)
            ->setPosition($categoryRow['position'])
            ->setActive($categoryRow['active']);

        if (!empty($categoryRow['idParentCategory'])) {
            $translation = new Translation;
            $translation->setIdLanguage($this->idLanguage)
                ->setIdTranslation($categoryRow['parentIdTranslation'])
                ->setTranslation($categoryRow['parentTranslation']);

            $parentCategory = new Category;
            $parentCategory->setIdCategory($categoryRow['parentIdCategory'])
                ->setName($translation)
                ->setPosition($categoryRow['parentPosition'])
                ->setActive($categoryRow['parentActive']);

            $category->setParentCategory($parentCategory);
        }

        return $category;
    }

    /**
     * @param array $categoryRow
     * @param Category $parentCategory
     * @return Category
     */
    private function arrayToCategory(array $categoryRow, Category $parentCategory = null)
    {
        $translation = new Translation;
        $translation->setIdLanguage($this->idLanguage)
            ->setIdTranslation($categoryRow['idTranslation'])
            ->setTranslation($categoryRow['translation']);

        $category = new Category;
        $category->setIdCategory($categoryRow['idCategory'])
            ->setName($translation)
            ->setPosition($categoryRow['position'])
            ->setActive($categoryRow['active']);

        if ($parentCategory) {
            $category->setParentCategory($parentCategory);
        }

        return $category;
    }

    private function getCategorySql()
    {
        return array('sql' => 'SELECT `Category`.`idCategory`, `Category`.`idParentCategory`, `Category`.`position`, `Category`.`active`, 
            `Translation`.`idTranslation`, `Translation`.`translation`,
            `ParentCategory`.`idCategory` AS `parentIdCategory`, `ParentCategory`.`position` AS `parentPosition`, 
            `ParentCategory`.`active` AS `parentActive`, `ParentTranslation`.`idTranslation` AS `parentIdTranslation`, 
            `ParentTranslation`.`translation` AS `parentTranslation`,
            IF(`ParentCategory`.`position` IS NULL, CONCAT(`Category`.`position`, 0), CONCAT(`ParentCategory`.`position`, `Category`.`Position`)) AS `positionOrder`
            FROM `Category`
            LEFT JOIN `Category` AS `ParentCategory` ON `Category`.`idParentCategory` = `ParentCategory`.`idCategory`
            JOIN `Translation` ON `Category`.`name` = `Translation`.`idTranslation`
            LEFT JOIN `Translation` AS `ParentTranslation` ON `ParentCategory`.`name` = `ParentTranslation`.`idTranslation`',
        'where' => ' `Category`.`active` = :active 
            AND (`ParentCategory`.`active` = :active OR `ParentCategory`.`active` IS NULL) 
            AND `Translation`.`idLanguage` = :idLanguage
            AND (`ParentTranslation`.`idLanguage` = :idLanguage OR `ParentTranslation`.`idLanguage` IS NULL)');
    }

}