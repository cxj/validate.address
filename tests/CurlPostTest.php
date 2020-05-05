<?php
/**
 * @file CurlPostTest.php
 * Replace with one line description.
 */
namespace Cxj;

use phpmock\phpunit\PHPMock;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CurlPostTest extends TestCase
{
    use PHPMock;

    public function testSuccess()
    {
        $curl_exec = $this->getFunctionMock(__NAMESPACE__, "curl_exec");
        $curl_exec->expects($this->once())->willReturn("<return></return>");

        $curl_getinfo = $this->getFunctionMock(__NAMESPACE__, "curl_getinfo");
        $curl_getinfo->expects($this->once())->willReturn(200);

        $test = new CurlPost("http://example.com");
        $this->assertEquals("<return></return>", $test->sendAndReceive("XML"));
    }

    public function testExecFail()
    {
        $curl_exec = $this->getFunctionMock(__NAMESPACE__, "curl_exec");
        $curl_exec->expects($this->once())->willReturn(false);

        $curl_error = $this->getFunctionMock(__NAMESPACE__, "curl_error");
        $curl_error->expects($this->once())->willReturn(42);

        $test = new CurlPost("http://example.com");
        $this->expectException(RuntimeException::class);
        $test->sendAndReceive("XML");
    }

   public function testHttpStatusFail()
   {
       $curl_exec = $this->getFunctionMock(__NAMESPACE__, "curl_exec");
       $curl_exec->expects($this->once())->willReturn("<return></return>");

       $curl_getinfo = $this->getFunctionMock(__NAMESPACE__, "curl_getinfo");
       $curl_getinfo->expects($this->once())->willReturn(404);

       $test = new CurlPost("http://example.com");
       $this->expectException(RuntimeException::class);
       $test->sendAndReceive("XML");
   }
}
