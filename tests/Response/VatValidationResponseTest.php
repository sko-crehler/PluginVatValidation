<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Test\Response;

use PHPUnit\Framework\TestCase;
use Plugin\VatValidation\Response\VatValidationResponse;
use Plugin\VatValidation\Struct\TraderStruct;

class VatValidationResponseTest extends TestCase
{
    public function testCreateWithValidData(): void
    {
        $traderStruct = new TraderStruct();
        $traderStruct->setTraderAddress('address');
        $traderStruct->setTraderName('name');

        $vatValidationResponse = new VatValidationResponse($traderStruct);
        static::assertInstanceOf(VatValidationResponse::class, $vatValidationResponse);
    }
}