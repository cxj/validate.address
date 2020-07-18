<?php
/**
 * @file ResponseParserInterface.php
 * Replace with one line description.
 */

namespace Cxj\ValidateAddress;


interface ResponseParserInterface
{
    public function parse(string $response): bool;

    public function getValue(string $key): string;
}
