<?php declare(strict_types=1);

namespace Plugin\VatValidation\Dto;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(schema="plugin_vat_validation_response")
 */
class TraderDataResponseDto
{
    /**
     * @OA\Property(type="string")
     */
    protected string $traderName;

    /**
     * @OA\Property(type="string")
     */
    protected string $traderAddress;

    /**
     * @return string
     */
    public function getTraderName(): string
    {
        return $this->traderName;
    }

    /**
     * @param string $traderName
     */
    public function setTraderName(string $traderName): void
    {
        $this->traderName = $traderName;
    }

    /**
     * @return string
     */
    public function getTraderAddress(): string
    {
        return $this->traderAddress;
    }

    /**
     * @param string $traderAddress
     */
    public function setTraderAddress(string $traderAddress): void
    {
        $this->traderAddress = $traderAddress;
    }
}