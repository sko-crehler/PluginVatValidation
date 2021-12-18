<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Test\Dto;

use PHPUnit\Framework\TestCase;
use Plugin\VatValidation\Dto\TraderDataRequestDto;

class TraderDataRequestDtoTest extends TestCase
{
    public function testGetVatNumber(): void
    {
        $traderDataRequestDto = new TraderDataRequestDto();
        $traderDataRequestDto->setVatNumber('5252546391');

        static::assertEquals('5252546391', $traderDataRequestDto->getVatNumber());
    }

    public function testGetCountryCode(): void
    {
        $traderDataRequestDto = new TraderDataRequestDto();
        $traderDataRequestDto->setCountryCode('PL');

        static::assertEquals('PL', $traderDataRequestDto->getCountryCode());
    }
}