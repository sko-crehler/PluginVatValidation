<?php declare(strict_types=1);

namespace SwagExample\Dto;

class TraderDataResponseDto
{
    public string $traderName;

    public string $traderAddress;

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