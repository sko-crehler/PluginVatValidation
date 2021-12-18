<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Test\Struct;

use PHPUnit\Framework\TestCase;
use Plugin\VatValidation\Struct\TraderStruct;

class TraderStructTest extends TestCase
{
    public function testGetTraderName(): void
    {
        $trader = new TraderStruct();
        $trader->setTraderName('Name');

        static::assertEquals('Name', $trader->getTraderName());
    }

    public function testGetTraderAddress(): void
    {
        $trader = new TraderStruct();
        $trader->setTraderAddress('Address');

        static::assertEquals('Address', $trader->getTraderAddress());
    }
}