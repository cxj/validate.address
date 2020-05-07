<?php
/**
 * @file StreamPost.php
 * Replace with one line description.
 */

namespace Cxj;


class StreamPost extends AbstractCommunicate
{

    public function sendAndReceive(string $addressXml): string
    {
        $xml    = $this->buildXmlRequest($addressXml);
        $fields = [
            "API" => "Verify",
            "XML" => $xml,
        ];

        $opts = [
            'http' =>
                [
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query($fields),
                ],
        ];

        $context = stream_context_create($opts);

        try {
            $return = file_get_contents($this->url, false, $context);
        }
        catch (\Exception $e) {
            // DEBUG
            error_log("file_get_contents exception: " . $e->getMessage());
            // END DEBUG
            // TODO
            throw new \RuntimeException("file_get_contents threw exception");
        }
        if (false === $return) {
            // TODO
            throw new \RuntimeException("file_get_contents returned false");
        }


    }
}
