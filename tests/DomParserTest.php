<?php
/**
 * @file DomParserTest.php
 * Replace with one line description.
 */
namespace Cxj\ValidateAddress;

use PHPUnit\Framework\TestCase;

class DomParserTest extends TestCase
{
    protected DomParser $parser;

    public function setUp(): void
    {
        $this->parser = new DomParser();
    }

    public function testParse(): void {
        $this->assertFalse($this->parser->parse("<Bogus XML>"));
        $this->assertTrue($this->parser->parse("<good>valid XML</good>"));
    }

    public function testGetValue(): void {
        $this->parser->parse("<foo>bar</foo>");
        $this->assertEquals("bar", $this->parser->getValue("foo"));
        $this->assertEquals("", $this->parser->getValue("does-not-exist"));
    }
}
