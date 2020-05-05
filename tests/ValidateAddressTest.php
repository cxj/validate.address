<?php
/**
 * @file ValidateAddressTest.php
 * Replace with one line description.
 */
namespace Cxj;

use PHPUnit\Framework\TestCase;

class ValidateAddressTest extends TestCase
{
    public function testSuccess(): void
    {
        $result = (new ValidateAddress())->validate("123 Main Street");
        $this->assertInstanceOf(Address::class, $result);
    }
}
