<?php
/**
 * @file CurlPost.php
 * Replace with one line description.
 */

namespace Cxj\ValidateAddress;


use Exception;
use RuntimeException;

/**
 * Class CurlPost
 * Provides an HTTP POST connection to USPS API address "Verify" service.
 * @package Cxj\ValidateAddress
 */
class CurlPost extends AbstractCommunicate
{
    /**
     * POST the XML string to the USPS server, and return the reply string.
     *
     * @param string $address
     *
     * @return string
     * @throws Exception
     */
    public function sendAndReceive(string $address): string
    {
        $xml        = $this->buildXmlRequest($address);
        $fields     = [
            "API" => "Verify",
            "XML" => $xml,
        ];
        $postFields = http_build_query($fields);
        $ch         = curl_init($this->url);

        // set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $return = curl_exec($ch);
        if (false === $return) {
            throw new RuntimeException(
                "curl_exec error: " . curl_error($ch),
                curl_errno($ch)
            );
        }
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpStatus != 200) {
            throw new RuntimeException("HTTP error: $httpStatus");
        }
        curl_close($ch);

        return $return;
    }
}
