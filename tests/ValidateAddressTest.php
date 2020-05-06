<?php
/**
 * @file ValidateAddressTest.php
 * Replace with one line description.
 */
namespace Cxj;

use PHPUnit\Framework\TestCase;

class ValidateAddressTest extends TestCase
{
    protected string $url;
    protected ValidateAddress $validator;
    protected Address $output;

    protected string $goodXmlOutput = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<AddressValidateResponse>
  <Address ID="0">
    <FirmName>CLAIMLYNX</FirmName>
    <Address1>STE 200</Address1>
    <Address2>10700 OLD COUNTY ROAD 15</Address2>
    <City>PLYMOUTH</City>
    <State>MN</State>
    <Zip5>55441</Zip5>
    <Zip4>6150</Zip4>
  </Address>
</AddressValidateResponse>
XML;


    public function setUp(): void
    {
        $this->url       = "http://example.com";
        $comm            = $this->getMockBuilder(CurlPost::class)
                                ->disableOriginalConstructor()
                                ->getMock();
        $parser          = $this->getMockBuilder(DomParser::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->validator = new ValidateAddress(
            $this->url,
            $comm,
            $parser
        );
    }

    public function testSuccess(): void
    {
        $address = new Address("123 Main Street");  // TODO
        $result = $this->validator->validate($address);
        $this->assertInstanceOf(Address::class, $result);
    }
}
