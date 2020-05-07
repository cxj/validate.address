<?php
/**
 * @file ValidateAddress.php
 * Replace with one line description.
 */

namespace Cxj;


class ValidateAddress
{
    protected string $url;
    protected CommunicateInterface $comm;
    protected Address $output;
    protected ResponseParserInterface $parser;

    public function __construct(
        string $url,
        CommunicateInterface $comm,
        ResponseParserInterface $parser
    )
    {
        $this->url    = $url;
        $this->comm   = $comm;
        $this->parser = $parser;
    }

    public function validate(Address $input): Address
    {
        $response = $this->comm->sendAndReceive($input->getXml());

        $this->parser->parse($response);

        return new Address("foo", $this->parser->getValue("Address1"));
    }

}
