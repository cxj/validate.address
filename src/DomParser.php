<?php declare(strict_types=1);
/**
 * Parses a simple XML response from USPS API.
 */

namespace Cxj;


class DomParser implements ResponseParserInterface
{
    protected \DOMDocument $dom;

    public function __construct()
    {
        $this->dom = new \DOMDocument($version = "", $encoding = "");
    }

    /**
     * @param string $xmlDoc - The USPS response XML document to parse.
     *
     * @return bool
     */
    public function parse(string $xmlDoc): bool
    {
        if ($this->dom->loadXML($xmlDoc) === false) {
            return false;
        }

        return true;
    }

    /**
     * Get the passed XML tag's value.
     * @param string $tag
     *
     * @return string - the FIRST matching element's value.
     */
    public function getValue(string $tag): string
    {
        $elements = $this->dom->getElementsByTagName($tag);
        if ($elements->length < 1) return "";
        return $elements->item(0)->nodeValue;
    }
}
