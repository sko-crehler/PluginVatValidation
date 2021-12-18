<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Test\Dto;

use PHPUnit\Framework\TestCase;
use Plugin\VatValidation\Dto\TraderDataResponseDto;

class TraderDataResponseDtoTest extends TestCase
{
    public function testGetName(): void
    {
        $traderDataResponseDto = new TraderDataResponseDto();
        $traderDataResponseDto->setName('Company Name');

        static::assertEquals('Company Name', $traderDataResponseDto->getName());
    }

    public function testGetAddress(): void
    {
        $traderDataResponseDto = new TraderDataResponseDto();
        $traderDataResponseDto->setAddress('Company Address');

        static::assertEquals('Company Address', $traderDataResponseDto->getAddress());
    }

    public function testGetCountryCode(): void
    {
        $traderDataResponseDto = new TraderDataResponseDto();
        $traderDataResponseDto->setCountryCode('Country Code');

        static::assertEquals('Country Code', $traderDataResponseDto->getCountryCode());
    }

    public function testGetVatNumber(): void
    {
        $traderDataResponseDto = new TraderDataResponseDto();
        $traderDataResponseDto->setVatNumber('123456789');

        static::assertEquals('123456789', $traderDataResponseDto->getVatNumber());
    }

    public function testGetRequestDate(): void
    {
        $traderDataResponseDto = new TraderDataResponseDto();
        $traderDataResponseDto->setRequestDate('2020-12-12');

        static::assertEquals('2020-12-12', $traderDataResponseDto->getRequestDate());
    }

    public function testIsValid(): void
    {
        $traderDataResponseDto = new TraderDataResponseDto();
        $traderDataResponseDto->setValid(true);

        static::assertEquals(true, $traderDataResponseDto->isValid());
    }
}