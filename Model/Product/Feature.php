<?php

namespace Model\Product;


use Model\Translation\Translation;

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
     * @var array
     */
    private $featureValues = array();

    /**
     * @param int $idFeature
     * @return Feature $this
     */
    public function setIdFeature($idFeature)
    {
        $this->idFeature = (int)$idFeature;

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
     * @param Translation $name
     * @return Feature $this
     */
    public function setName(Translation $name)
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
     * @param FeatureValue $featureValue
     * @return Feature $this
     */
    public function addFeatureValue(FeatureValue $featureValue)
    {
        $this->featureValues[] = $featureValue;

        return $this;
    }

    /**
     * @param array $featureValues
     * @return Feature $this
     */
    public function setFeatureValues(array $featureValues)
    {
        foreach ($featureValues as $featureValue) {
            $this->addFeatureValue($featureValue);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getFeatureValues()
    {
        return $this->featureValues;
    }

    /**
     * @return array
     */
    public function JSONSerialize()
    {
        return get_object_vars($this);
    }
}
