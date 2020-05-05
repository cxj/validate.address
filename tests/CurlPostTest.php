<?php
/**
 * @file CurlPostTest.php
 * Replace with one line description.
 */
namespace Cxj;

use PHPUnit\Framework\TestCase;

function curl_exec($ch)
{
    return "Hi there, $ch";
}

class CurlPostTest extends TestCase
{
    public function testNamespace()
    {
        $return = curl_exec("foo");
        $this->assertEquals("Hi there, foo", $return);
    }
}
