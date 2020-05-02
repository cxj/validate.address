<?php
/**
 * @file AddressTest.php
 * Replace with one line description.
 */
namespace Cxj;

use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    protected Address $address;

    const ADDRESS_1 = "123 Main Street";

    protected function setUp(): void
    {
        $this->address = new Address(self::ADDRESS_1);
    }

    public function testXml(): void
    {
        $address1 = self::ADDRESS_1;
        $xml      = <<< XML
<FirmName></FirmName>
<Address1>$address1</Address1>
<Address2></Address2>
<City></City>
<State></State>
<Zip5></Zip5>
<Zip4></Zip4>
XML;

        $actual = $this->address->getXml();
        // DEBUG
        error_log("testXml ACTUAL:\n" . $actual . PHP_EOL);
        error_log("testXml EXPECT:\n" . $xml . PHP_EOL);
        // END DEBUG
        $this->assertEquals($xml, $actual);
    }

    public function testMaxCityLength(): void
    {
        $address1 = self::ADDRESS_1;
        $badCity  = "city5678901234567890";
        $this->address->setCity($badCity);

        $city     = substr($badCity, 0, 15);

        $xml = <<< XML
<FirmName></FirmName>
<Address1>$address1</Address1>
<Address2></Address2>
<City>$city</City>
<State></State>
<Zip5></Zip5>
<Zip4></Zip4>
XML;

        $actual = $this->address->getXml();
        // DEBUG
        error_log("testMaxCityLength ACTUAL: " . $actual);
        error_log("testMaxCityLength EXPECT: " . $xml);
        // END DEBUG

        $this->assertNotEquals($xml, $actual);
    }
}
