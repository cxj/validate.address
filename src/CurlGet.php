<?php
/**
 * @file CurlGet.php
 * Replace with one line description.
 */

namespace Cxj;

use RuntimeException;

class CurlGet extends AbstractCommunicate
{
    /**
     * Send the XML string to the USPS server via HTTP GET, and return reply.
     *
     * @param string $address
     *
     * @return string
     */
    public function sendAndReceive(string $address): string
    {
        $xml        = $this->buildXmlRequest($address);
        $encodedXml = urlencode($xml);
        $ch         = curl_init($this->url . "?API=Verify&XML=" . $encodedXml);

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
