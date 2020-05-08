<?php
/**
 * @file CurlPostTest.php
 * Replace with one line description.
 */
namespace Cxj;

use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CurlPostTest extends TestCase
{
    use PHPMock;

    protected CurlPost $test;

    public function setUp(): void
    {
        $this->test = new CurlPost("username");
    }

    public function testSuccess(): void
    {
        $curl_exec = $this->getFunctionMock(__NAMESPACE__, "curl_exec");
        $curl_exec->expects($this->once())->willReturn("<return></return>");

        $curl_getinfo = $this->getFunctionMock(__NAMESPACE__, "curl_getinfo");
        $curl_getinfo->expects($this->once())->willReturn(200);

        $this->assertEquals(
            "<return></return>",
            $this->test->sendAndReceive("XML")
        );
    }

    public function testExecFail(): void
    {
        $curl_exec = $this->getFunctionMock(__NAMESPACE__, "curl_exec");
        $curl_exec->expects($this->once())->willReturn(false);

        $curl_error = $this->getFunctionMock(__NAMESPACE__, "curl_error");
        $curl_error->expects($this->once())->willReturn(42);

        $this->expectException(RuntimeException::class);
        $this->test->sendAndReceive("XML");
    }

    public function testHttpStatusFail(): void
    {
        $curl_exec = $this->getFunctionMock(__NAMESPACE__, "curl_exec");
        $curl_exec->expects($this->once())->willReturn("<return></return>");

        $curl_getinfo = $this->getFunctionMock(__NAMESPACE__, "curl_getinfo");
        $curl_getinfo->expects($this->once())->willReturn(404);

        $this->expectException(RuntimeException::class);
        $this->test->sendAndReceive("XML");
    }
}
