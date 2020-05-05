<?php
/**
 * @file ValidateAddress.php
 * Replace with one line description.
 */

namespace Cxj;


class ValidateAddress
{
    /**
     * @var callable
     */
    protected $callApi;

    public function validate(
        string $street1,
        string $street2 = "",
        string $city = "",
        string $state = "",
        string $zip = "",
        string $firm = ""
    ): Address
    {
        $requestAddress = new Address($street1);
        $requestAddress->setAddress2($street2);

        try {
            $this->callApi = new CurlPost($url);
        }
        catch (\Exception $e) {

        }

        return $this->callApi->sendAndReceive($requestAddress);
    }
}
