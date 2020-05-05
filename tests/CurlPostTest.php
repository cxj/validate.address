<?php
/**
 * @file CurlPostTest.php
 * Replace with one line description.
 */
namespace Cxj;

use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

class CurlPostTest extends TestCase
{
    use PHPMock;

    public function testCurl()
    {
        $curl_exec = $this->getFunctionMock(__NAMESPACE__, "curl_exec");
        $curl_exec->expects($this->once())->willReturn("body");

        $ch = curl_init();
        $this->assertEquals("body", curl_exec($ch));
    }

    public function testSuccess()
    {
        $curl_exec = $this->getFunctionMock(__NAMESPACE__, "curl_exec");
        $curl_exec->expects($this->once())->willReturn("<return></return>");

        $curl_getinfo = $this->getFunctionMock(__NAMESPACE__, "curl_getinfo");
        $curl_getinfo->expects($this->once())->willReturn(200);

        $test = new CurlPost("http://example.com");
        $this->assertEquals("<return></return>", $test->sendAndReceive("XML"));
    }

    public function testTime()
    {
        $time = $this->getFunctionMock(__NAMESPACE__, "time");
        $time->expects($this->once())->willReturn(3);

        $this->assertEquals(3, time());
    }
}
