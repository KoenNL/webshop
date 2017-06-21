<?php

namespace Model\Category;

use Model\Translation\Translation;

class Category
{
    /**
     * @var int
     */
    private $idCategory;
    /**
     * @var Category
     */
    private $parentCategory;
    /**
     * @var Translation
     */
    private $name;
    /**
     * @var int
     */
    private $position;
    /**
     * @var bool
     */
    private $active = true;

    /**
     * @param int $idCategory
     * @return Category $this
     */
    public function setIdCategory($idCategory)
    {
        $this->idCategory = (int) $idCategory;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }

    /**
     * @param Category $category
     * @return Category $this
     */
    public function setParentCategory(Category $category)
    {
        $this->parentCategory = $category;

        return $this;
    }

    /**
     * @return Category
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * @param Translation $name
     * @return Category $this
     */
    public function setName(Translation $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Translation
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $position
     * @return Category $this
     */
    public function setPosition($position)
    {
        $this->position = (int) $position;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param bool $active
     * @return Category $this
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }
}