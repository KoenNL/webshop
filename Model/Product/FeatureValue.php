<?php

namespace Model\Product;


class FeatureValue implements \JsonSerializable
{

    /**
     * @var int
     */
    private $idFeatureValue;
    /**
     * @var int
     */
    private $idFeature;
    /**
     * @var string
     */
    private $value;

    /**
     * @param int $idFeatureValue
     * @return FeatureValue $this
     */
    public function setIdFeatureValue($idFeatureValue)
    {
        $this->idFeatureValue = (int) $idFeatureValue;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdFeatureValue()
    {
        return $this->idFeatureValue;
    }

    /**
     * @param int $idFeature
     * @return FeatureValue $this
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
     * @param string $value
     * @return FeatureValue $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}