<?php declare(strict_types=1);
/**
 * Parses a simple XML response from USPS API.
 */

namespace Cxj\ValidateAddress;

class XmlParser implements ResponseParserInterface
{
    /**
     * @var resource
     */
    protected $xmlParser;
    /**
     * @var array<mixed>
     */
    protected array $values = [];
    /**
     * @var array <mixed>
     */
    protected array $outputs = [];

    public function __construct()
    {
        $this->xmlParser = xml_parser_create();
    }

    /**
     * @param string $xmlDoc - The USPS Response XML document to parse.
     *
     * @return bool
     */
    public function parse(string $xmlDoc): bool
    {
        if (0 === xml_parse_into_struct(
                $this->xmlParser,
                $xmlDoc,
                $this->values
            )
        ) {
            return false;
        }

        xml_parser_free($this->xmlParser);
        unset($this->xmlParser);

        // cycle through $tags and build our sensible address array
        $this->outputs = [];
        $index         = 0;
        /**
         * @var array<mixed> $value
         */
        foreach ($this->values as $key => $value) {

            if ($value["tag"] != 'ADDRESSVALIDATERESPONSE') {
                if ($value["tag"] == 'ADDRESS') {
                    if ($value['type'] == "open") {
                        $index = $value["attributes"]["ID"];
                    }
                    continue;
                }

                if (isset($value["value"])) {
                    $this->outputs[$index]["{$value["tag"]}"] = $value["value"];
                }
            }
        }

        return true;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getValue(string $key): string
    {
        return $this->outputs[0][strtoupper($key)] ?? "";
    }
}
