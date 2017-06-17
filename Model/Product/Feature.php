<?php

namespace Model\Product;


class Feature implements \JsonSerializable
{
    /**
     * @var int
     */
    private $idFeature;
    /**
     * @var string
     */
    private $name;

    /**
     * @param int $idFeature
     * @return Feature $this
     */
    public function setIdFeature($idFeature)
    {
        $this->idFeature = (int) $idFeature;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdFeature()
    {
        return $this->idFeature;
    }

    /**
     * @param string $name
     * @return Feature $this
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
     * @return array
     */
    public function JSONSerialize()
    {
        return get_object_vars($this);
    }
}