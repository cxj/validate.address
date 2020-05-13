<?php
/**
 * @file Address.php
 * Replace with one line description.
 */
declare(strict_types=1);

namespace Cxj;

/*
interface ValueObject
{
    public function isNull(): bool;
    public function isSame(ValueObject $object): bool;
    public static function fromNative($native);
    public function toNative();
}
*/

use Webmozart\Assert\Assert;

/**
 * Class Address - Parameter Object for Address Validation Service.
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
    protected string $firmName;     // Optional.
    protected string $address1;     // Always Required!
    protected string $address2;     // secondary unit, e.g. APT, SUITE
    protected string $city;         // max length 15
    protected string $state;        // Must be length 2
    protected string $zip5;         // Must be length 5
    protected string $zip4;         // digits only, must be length 9
    protected string $urbanization; // max length 28

    // We don't remove empty constructor because it still needs to be private.
    private function __construct() { }

    /**
     * Address constructor from JSON objects.
     *
     * @param string $json
     *
     * @return Address
     */
    public static function fromJson(string $json): Address
    {
        if (!extension_loaded("json")) {
            throw new \RuntimeException("PHP's ext-json is not installed");
        }

        $params = json_decode($json, true, JSON_THROW_ON_ERROR);

        return Address::fromArray($params);
    }

    /**
     * Address constructor from associative array.
     *
     * @param array<string> $params
     *
     * @return Address
     */
    public static function fromArray(array $params): Address
    {
        $normal = array_change_key_case($params, CASE_LOWER);

        return Address::fromVars(
            $normal["address1"] ?? "",
            $normal["address2"] ?? "",
            $normal["city"] ?? "",
            $normal["state"] ?? "",
            $normal["zip5"] ?? "",
            $normal["zip4"] ?? "",
            // Note lowercase "n" due to case change in key name below:
            $normal["firmname"] ?? "",
            $normal["urbanization"] ?? ""
        );
    }

    /**
     * Address constructor from individual variables.
     *
     * @param string $address1
     * @param string $address2
     * @param string $city
     * @param string $state
     * @param string $zip5
     * @param string $zip4
     * @param string $firmName
     * @param string $urbanization
     *
     * @return Address
     */
    public static function fromVars(
        string $address1,
        string $address2 = "",
        string $city = "",
        string $state = "",
        string $zip5 = "",
        string $zip4 = "",
        string $firmName = "",
        string $urbanization = ""
    ): Address
    {
        // Assert::stringNotEmpty($address1, "Address1 is required");
        Assert::maxLength($address1, 128, "Address1 too long");
        Assert::lengthBetween($address2, 0, 128, "Address2 too long");
        Assert::lengthBetween($city, 0, 15, "City too long");
        if (!empty($state)) {
            Assert::length($state, 2, "State must be 2 letters");
            Assert::alpha($state, "State must be 2 letters");
        }
        if (!empty($zip5)) {
            Assert::length($zip5, 5, "ZIP Code must be length 5");
            Assert::numeric($zip5, "ZIP Code must contains only digits");
        }
        if (!empty($zip4)) {
            Assert::length($zip4, 4, "ZIP+4 must be length 4");
            Assert::numeric($zip4, "ZIP+4 must contains only digits");
        }
        Assert::lengthBetween($urbanization, 0, 28, "Urbanization too long");

        $address = new Address();

        $address->firmName     = $firmName;
        $address->address1     = $address1;
        $address->address2     = $address2;
        $address->city         = $city;
        $address->state        = $state;
        $address->zip5         = $zip5;
        $address->zip4         = $zip4;
        $address->urbanization = $urbanization;

        return $address;
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
     * @return string
     */
    public function getFirmName(): string
    {
        return $this->firmName;
    }

    /**
     * @return string
     */
    public function getAddress1(): string
    {
        return $this->address1;
    }

    /**
     * @return string
     */
    public function getAddress2(): string
    {
        return $this->address2;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getZip5(): string
    {
        return $this->zip5;
    }

    /**
     * @return string
     */
    public function getZip4(): string
    {
        return $this->zip4;
    }

    /**
     * @return string
     */
    public function getUrbanization(): string
    {
        return $this->urbanization;
    }
}
