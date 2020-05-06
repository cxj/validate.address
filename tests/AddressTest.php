<?php
/**
 * @file AddressTest.php
 * Replace with one line description.
 */
namespace Cxj;

use Exception;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    const ADDRESS_1 = "123 Main Street";

    public function testAddressXml(): void
    {
        $address1 = self::ADDRESS_1;
        $address  = new Address($address1);
        $xml      = <<< XML
<FirmName></FirmName>
<Address1>$address1</Address1>
<Address2></Address2>
<City></City>
<State></State>
<Zip5></Zip5>
<Zip4></Zip4>
XML;
        $actual   = $address->getXml();
        $this->assertEquals($xml, $actual);
    }

    public function testAddressMaxAddress2Length(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, $this->genString(129));
    }

    public function testAddressMaxCityLength(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, "", $this->genString(16));
    }

    public function testAddressStateTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, "", "Anytown", "M");
    }

    public function testAddressStateTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, "", "Anytown", "ABC");
    }

    public function testAddressStateNotAlpha(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, "", "Anytown", "42");
    }

    public function testAddressZip5Ok(): void {
        $address = new Address(self::ADDRESS_1, "", "City", "", "12345");
        $this->assertInstanceOf(Address::class, $address);
    }

    public function testAddressZip5TooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, "", "Anytown", "AE", "1234");
    }

    public function testAddressZip5TooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, "", "Anytown", "AE", "123456789");
    }

    public function testAddressZip5Numeric(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, "", "Anytown", "AE", "ABCD5");
    }


    public function testAddressZip4TooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, "", "Anytown", "AE", "", "123");
    }

    public function testAddressZip4TooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address(self::ADDRESS_1, "", "Anytown", "AE", "", "123456789");
    }

    public function testAddressZip4Numeric(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tryNew("", "Anytown", "AE", "", "ABC4");
        // new Address(self::ADDRESS_1, "", "Anytown", "AE", "", "ABC4");
    }


    protected function tryNew(
        string $address2 = "",
        string $city = "",
        string $state = "",
        string $zip5 = "",
        string $zip4 = "",
        string $urban = ""
    ): Address
    {
        $firmName = "";

        try {
            $address = new Address(
                self::ADDRESS_1,
                $address2,
                $city,
                $state,
                $zip5,
                $zip4,
                $firmName,
                $urban
            );
        }
        catch (Exception $e) {
            error_log("New Address exception: " . $e->getMessage());
            error_log("File {$e->getFile()} line {$e->getLine()}");
            error_log("Exception type: " . get_class($e));

            throw $e;
            // $this->fail("Fail at line: " . $e->getLine());
        }

        return $address;
    }

    /**
     * Helper function to generate random strings of given length.
     *
     * @param int $length
     *
     * @return string
     */
    protected function genString(int $length): string
    {
        // First 2 chars are chosen at random from printable ASCII.
        $string = str_repeat(
            chr(rand(33, 126)) . chr(rand(33, 126)),
            $length / 2
        );
        if ($length % 2) {
            $string .= "1";
        }

        return $string;
    }
}
