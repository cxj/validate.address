<?php
/**
 * @file CommunicateInterface.php
 * Replace with one line description.
 */

namespace Cxj;


interface CommunicateInterface
{
    public function sendAndReceive(string $xml): string;
}
