<?php
/**
 * @file Result.php
 * Replace with one line description.
 */

declare(strict_types=1);

namespace Cxj\ValidateAddress;

/**
 * Returned data Value Object for USPS address validation service.
 */
class Result
{
    protected Address $address;
    protected string $returnText;
    protected string $description;
    protected bool $error;

    public function __construct(
        Address $address,
        string $returnText = '',
        string $description = '',
        bool $hasError = false
    )
    {
        $this->address     = $address;
        $this->returnText  = $returnText;
        $this->description = $description;
        $this->error       = $hasError;
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

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->error;
    }
}
