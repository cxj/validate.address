<?php
/**
 * @file ValidateAddressTest.php
 * Replace with one line description.
 */
namespace Cxj;

use PHPUnit\Framework\TestCase;

class ValidateAddressTest extends TestCase
{
    protected ValidateAddress $validator;

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
        $comm   = $this->getMockBuilder(CurlPost::class)
                       ->disableOriginalConstructor()
                       ->getMock();
        $parser = $this->getMockBuilder(DomParser::class)
                       ->disableOriginalConstructor()
                       ->getMock();

        $map = [
            ["Address1", "This is Address1"],
            ["Address2", "Suite 222"],
            ["City", "Anytown"],
            ["State", "AE"],
            ["Zip5", "12345"],
            ["Zip4", "7890"],
            ["FirmName", "Acme Chemicals and Anvils"],
            ["Urbanization", "Puerto Rico Only"],
        ];
        $parser->expects($this->any())
               ->method("getValue")
               ->will($this->returnValueMap($map));


        /** @var CommunicateInterface $comm */
        /** @var ResponseParserInterface $parser */
        $this->validator = new ValidateAddress($comm, $parser);
    }

    public function testSuccess(): void
    {
        $address = new Address("123 Main Street");
        $result  = $this->validator->validate($address);
        $this->assertInstanceOf(Address::class, $result);
    }
}
