<?php

namespace Model\Shop;

class Shop
{

    /**
     * @var int
     */
    private $idShop;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $emailAddress;
    /**
     * @var float
     */
    private $shippingCosts;
    /**
     * @var float
     */
    private $shippingCostsThreshold;
    /**
     * @var float
     */
    private $defaultCombinationDiscount;
    /**
     * @var float
     */
    private $defaultTax;
    /**
     * @var string
     */
    private $idLanguage;

    /**
     * @param int $idShop
     * @return Shop $this
     */
    public function setIdShop($idShop)
    {
        $this->idShop = (int) $idShop;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdShop()
    {
        return $this->idShop;
    }

    /**
     * @param string $name
     * @return Shop $this
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
     * @param string $emailAddress
     * @return Shop $this
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param float $shippingCosts
     * @return Shop $this
     */
    public function setShippingCosts($shippingCosts)
    {
        $this->shippingCosts = floatval($shippingCosts);

        return $this;
    }

    /**
     * @return float
     */
    public function getShippingCosts()
    {
        return $this->shippingCosts;
    }

    /**
     * @param float $shippingCostsThreshold
     * @return Shop $this
     */
    public function setShippingCostsThreshold($shippingCostsThreshold)
    {
        $this->shippingCostsThreshold = floatval($shippingCostsThreshold);

        return $this;
    }

    /**
     * @return float
     */
    public function getShippingCostsThreshold()
    {
        return $this->shippingCostsThreshold;
    }

    /**
     * @param float $defaultCombinationDiscount
     * @return Shop $this
     */
    public function setDefaultCombinationDiscount($defaultCombinationDiscount)
    {
        $this->defaultCombinationDiscount = floatval($defaultCombinationDiscount);

        return $this;
    }

    /**
     * @return float
     */
    public function getDefaultCombinationDiscount()
    {
        return $this->defaultCombinationDiscount;
    }

    /**
     * @param float $defaultTax
     * @return Shop $this
     */
    public function setDefaultTax($defaultTax)
    {
        $this->defaultTax = floatval($defaultTax);

        return $this;
    }

    /**
     * @return float
     */
    public function getDefaultTax()
    {
        return $this->defaultTax;
    }

    /**
     * @param string $language
     * @return Shop $this
     */
    public function setIdLanguage($language)
    {
        $this->idLanguage = $language;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdLanguage()
    {
        return $this->idLanguage;
    }
}