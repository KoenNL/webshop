<?php

namespace Model\Category;

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
     * @var string
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
     * @param string $name
     * @return Category $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
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