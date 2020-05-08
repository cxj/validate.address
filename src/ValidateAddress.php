<?php
/**
 * Use USPS Web API to validate and standardize mailing addresses.
 */

namespace Cxj;


use RuntimeException;

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

    /**
     * @param Address $input
     *
     * @return Address
     * @throws RuntimeException
     */
    public function validate(Address $input): Address
    {
        $response = $this->comm->sendAndReceive($input->getXml());

        if (false === $this->parser->parse($response)) {
            throw new RuntimeException("loadXML() failed");
        }

        if (!empty($this->parser->getValue("Error"))) {
            throw new RuntimeException(
                "USPS returned: " . $this->parser->getValue("Description")
            );
        }

        return new Address(
            $this->parser->getValue("Address1"),
            $this->parser->getValue("Address2"),
            $this->parser->getValue("City"),
            $this->parser->getValue("State"),
            $this->parser->getValue("Zip5"),
            $this->parser->getValue("Zip4"),
            $this->parser->getValue("FirmName"),
            $this->parser->getValue("Urbanization")
        );
    }
}
