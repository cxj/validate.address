<?php
/**
 * @file Result.php
 * Replace with one line description.
 */

declare(strict_types=1);

namespace Cxj;

/**
 * Returned data Value Object for USPS address validation service.
 */
class Result
{
    protected Address $address;
    protected string $returnText;
    protected string $description;

    public function __construct(
        Address $address,
        string $returnText = '',
        string $description = ''
    )
    {
        $this->address     = $address;
        $this->returnText  = $returnText;
        $this->description = $description;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getReturnText(): string
    {
        return $this->returnText;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
