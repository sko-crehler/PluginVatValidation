<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Dto;

class TraderDataResponseDto
{
    protected string $traderName;

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