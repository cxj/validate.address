<?php
/**
 * @file Address.php
 * Replace with one line description.
 */
declare(strict_types=1);

namespace Cxj;

/**
 * Class Address - Value Object for Address Validation Service
 * @package Cxj
 */
class Address
{
    /*
<FirmName>XYZ Corp.</FirmName>
<Address1>SUITE K</Address1>
<Address2>29851 Aventura</Address2>
<City/>
<State>CA</State>
<Urbanization>PuertoRicoOnly</Urbanization>
<Zip5>92688</Zip5>
<Zip4/>
     */
    protected string $firmName = "";     // Optional.
    protected string $address1 = "";     // Always Required!
    protected string $address2 = "";     // secondary unit, e.g. APT, SUITE
    protected string $city = "";         // max length 15
    protected string $state = "";        // Must be length 2
    protected string $zip5 = "";         // Must be length 5
    protected string $zip4 = "";         // digits only, must be length 9
    protected string $urbanization = ""; // max length 28

    /**
     * Address constructor.
     * Relies on all values initialized to empty strings above.
     *
     * @param string $address1 - the one required property
     */
    public function __construct(string $address1)
    {
        $this->setAddress1($address1);
    }

    /**
     * @return string - Values as XML.
     */
    public function getXml(): string
    {
        return <<< XML
<FirmName>$this->firmName</FirmName>
<Address1>$this->address1</Address1>
<Address2>$this->address2</Address2>
<City>$this->city</City>
<State>$this->state</State>
<Zip5>$this->zip5</Zip5>
<Zip4>$this->zip4</Zip4>
XML;
    }

    /**
     * @param string $firmName
     */
    public function setFirmName(string $firmName): void
    {
        $this->firmName = $firmName;
    }

    /**
     * @param string $address1
     */
    public function setAddress1(string $address1): void
    {
        $this->address1 = $address1;
    }

    /**
     * @param string $address2
     */
    public function setAddress2(string $address2): void
    {
        $this->address2 = $address2;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        if (strlen($city) <= 15) {
            $this->city = $city;
        }
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        if (strlen($state) == 2) {
            $this->state = $state;
        }
    }

    /**
     * @param string $zip5
     */
    public function setZip5(string $zip5): void
    {
        if (is_numeric($zip5) and (strlen($zip5) == 5)) {
            $this->zip5 = $zip5;
        }
    }

    /**
     * @param string $zip4
     */
    public function setZip4(string $zip4): void
    {
        if (empty($zip4) or (is_numeric($zip4) and (strlen($zip4) == 4))) {
            $this->zip4 = $zip4;
        }
    }

    /**
     * @param string $urbanization
     */
    public function setUrbanization(string $urbanization): void
    {
        if (strlen($urbanization) <= 28) {
            $this->urbanization = $urbanization;
        }
    }
}
