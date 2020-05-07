<?php
/**
 * @file AbstractCommunicate.php
 * Replace with one line description.
 */

namespace Cxj;


abstract class AbstractCommunicate implements CommunicateInterface
{
    protected string $user;
    protected string $url;

    public function __construct(string $url, string $user)
    {
        $this->url  = $url;
        $this->user = $user;
    }

    abstract public function sendAndReceive(string $xmlAddress): string;

    protected function buildXmlRequest(string $xmlAddress): string
    {
        return <<<XML
<AddressValidateRequest USERID={$this->user}">
    <Address ID="0">
        $xmlAddress
    </Address>
</AddressValidateRequest>
XML;
    }
}
