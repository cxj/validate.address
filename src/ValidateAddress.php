<?php
/**
 * Use USPS Web API to validate and standardize mailing addresses.
 */

namespace Cxj\ValidateAddress;


use RuntimeException;

class ValidateAddress
{
    const PARSE_ERROR = 1;
    const DATA_ERROR  = 2;

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
     * @return Result
     * @throws RuntimeException
     */
    public function validate(Address $input): Result
    {
        $response = $this->comm->sendAndReceive($input->getXml());

        if (false === $this->parser->parse($response)) {
            throw new RuntimeException("loadXML() failed", self::PARSE_ERROR);
        }

        return new Result(
            Address::fromVars(
                $this->parser->getValue("Address1"),
                $this->parser->getValue("Address2"),
                $this->parser->getValue("City"),
                $this->parser->getValue("State"),
                $this->parser->getValue("Zip5"),
                $this->parser->getValue("Zip4"),
                $this->parser->getValue("FirmName"),
                $this->parser->getValue("Urbanization"),
            ),
            $this->parser->getValue("ReturnText"),
            $this->parser->getValue("Description"),
            empty($this->parser->getValue("Error"))
        );
    }
}
