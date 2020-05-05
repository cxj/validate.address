<?php
/**
 * @file CurlPost.php
 * Replace with one line description.
 */

namespace Cxj;


use Exception;

/**
 * Class CurlPost
 * Provides an HTTP POST connection to USPS API address "Verify" service.
 * @package Cxj
 */
class CurlPost implements CommunicateInterface
{
    protected string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * POST the XML string to the USPS server, and return the reply string.
     *
     * @param string $xml
     *
     * @return string
     * @throws Exception
     */
    public function sendAndReceive(string $xml): string
    {
        $fields = [
            "API" => "Verify",
            "XML" => $xml,
        ];

        // build the urlencoded data
        $postFields = http_build_query($fields);

        // open connection
        $ch = curl_init($this->url);

        // set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // execute post
        $return = curl_exec($ch);
        if (false === $return) {
            throw new Exception("curl_exec error: " . curl_error($ch));
        }
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpStatus != 200) {
            throw new Exception("HTTP error: $httpStatus");
        }
        curl_close($ch);

        return $return;
    }
}
