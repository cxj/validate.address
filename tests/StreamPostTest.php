<?php
/**
 * @file StreamPostTest.php
 * Replace with one line description.
 */
namespace Cxj;

use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

class StreamPostTest extends TestCase
{
    use PHPMock;

    protected StreamPost $post;

    public function setUp(): void
    {
        $this->post = new StreamPost("username");
    }

    public function testSuccess(): void
    {
        $stream_context_create =
            $this->getFunctionMock(__NAMESPACE__, "stream_context_create");
        $stream_context_create->expects($this->once())->willReturn("foo");

        $file_get_contents =
            $this->getFunctionMock(__NAMESPACE__, "file_get_contents");
        $file_get_contents->expects($this->once())->willReturn(
            "<output></output>"
        );

        $this->assertEquals(
            "<output></output>",
            $this->post->sendAndReceive("XML")
        );
    }
}
