<?php
/**
 * @file ValidateAddress.php
 * Replace with one line description.
 */

namespace Cxj;


class ValidateAddress
{
    protected CommunicateInterface $comm;
    protected ResponseParserInterface $parser;

    public function __construct(
        CommunicateInterface $comm,
        ResponseParserInterface $parser
    )
    {
        $this->comm   = $comm;
        $this->parser = $parser;
    }

    public function validate(Address $input): Address
    {
        $response = $this->comm->sendAndReceive($input->getXml());

        $this->parser->parse($response);

        var_dump($this->parser->getValue("Address1"));  // DEBUG
        var_dump($this->parser->getValue("Address2"));  // DEBUG
        var_dump($this->parser->getValue("City"));  // DEBUG

        return new Address(
            $this->parser->getValue("Address1"),
            $this->parser->getValue("Address2"),
            $this->parser->getValue("City")
        );
    }

}
