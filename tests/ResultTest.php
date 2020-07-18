<?php
/**
 * @file ResultTest.php
 * Replace with one line description.
 */
namespace Cxj\ValidateAddress;

use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    const ADDRESS_1   = '123 Main Street';
    const RETURN_TEXT = 'return text';
    const DESCRIPTION = 'description';

    protected Address $address;
    protected Result $result;

    public function setUp(): void
    {
        $address1      = self::ADDRESS_1;
        $this->address = Address::fromVars($address1);
        $this->result  =
            new Result(
                $this->address,
                self::RETURN_TEXT,
                self::DESCRIPTION,
                true
            );
    }

    public function testConstruct(): void
    {
        $result = new Result($this->address);
        $this->assertInstanceOf(Result::class, $result);
    }

    public function testGetAddress(): void
    {
        $this->assertInstanceOf(
            Address::class,
            $this->result->getAddress()
        );
    }

    public function testGetAddress1(): void
    {
        $this->assertEquals(
            self::ADDRESS_1,
            $this->result->getAddress()->getAddress1()
        );
    }

    public function testGetReturnText(): void
    {
        $this->assertEquals(
            self::RETURN_TEXT,
            $this->result->getReturnText()
        );
    }

    public function testGetDescription(): void
    {
        $this->assertEquals(
            self::DESCRIPTION,
            $this->result->getDescription()
        );
    }

    public function testHasError(): void
    {
        $this->assertTrue($this->result->hasError());
    }
}
