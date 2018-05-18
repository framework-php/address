<?php

namespace GuilhermeHideki\Core\Address;

/**
 * Address
 *
 * @property string ibge
 *
 * @package GuilhermeHideki\Core\Address
 */
class Address
{
    /**
     * Address lines
     *
     * @var string[]
     */
    protected $addressLines;

    /**
     * The administrative area (state).
     *
     * @var string
     */
    protected $administrativeArea;

    /**
     * Dependent Locality (neighbourhood)
     *
     * @var string
     */
    protected $dependentLocality;

    /**
     * The locality (city)
     *
     * @var string
     */
    protected $locality;

    /**
     * Postal Code (Zip Code, CEP)
     *
     * @var string
     */
    protected $postalCode;

    /**
     * Creates an Address instance.
     *
     * @param string $administrativeArea
     * @param string $locality
     * @param string $dependentLocality
     * @param string $postalCode
     * @param array  $addressLines
     */
    public function __construct(
        $administrativeArea = '',
        $locality = '',
        $dependentLocality = '',
        $postalCode = '',
        $addressLines = []
    ) {
        $this->administrativeArea = $administrativeArea;
        $this->locality = $locality;
        $this->dependentLocality = $dependentLocality;
        $this->postalCode = $postalCode;
        $this->addressLines = $addressLines;
    }

    /**
     * Gets the the address line
     *
     * @param int $lineNumber Number of the line
     *
     * @return string[]
     */
    public function getAdressLine($lineNumber)
    {
        return $this->adressLines[$lineNumber];
    }

    /**
     * Gets the address lines
     *
     * @return string[]
     */
    public function getAdressLines()
    {
        return $this->adressLines;
    }

    /**
     * Sets the address lines
     *
     * @param string[] $addressLines Address lines
     *
     * @return self
     */
    public function setAdressLines($addressLines)
    {
        $this->adressLines = $addressLines;

        return $this;
    }

    /**
     * Gets the value of administrativeArea
     *
     * @return string
     */
    public function getAdministrativeArea()
    {
        return $this->administrativeArea;
    }

    /**
     * Sets the value of administrativeArea
     *
     * @return self
     */
    public function setAdministrativeArea($administrativeArea)
    {
        $this->administrativeArea = $administrativeArea;

        return $this;
    }

    /**
     * Gets the Dependent Locality
     *
     * @return string
     */
    public function getDependentLocality()
    {
        return $this->dependentLocality;
    }

    /**
     * Sets the Dependent Locality
     *
     * @param string  $dependentLocality
     *
     * @return self
     */
    public function setDependentLocality(string $dependentLocality)
    {
        $this->dependentLocality = $dependentLocality;

        return $this;
    }

    /**
     * Gets the Locality
     *
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Sets the Locality
     *
     * @param string $locality
     *
     * @return self
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Gets the Postal Code
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Sets the postal Code
     *
     * @param string $postalCode Postal Code (Zip Code, CEP)
     *
     * @return self
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }
}