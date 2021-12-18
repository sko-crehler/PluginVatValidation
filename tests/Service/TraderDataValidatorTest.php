<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Test\Service;

use PHPUnit\Framework\TestCase;
use Plugin\VatValidation\Service\TraderDataValidator;

class TraderDataValidatorTest extends TestCase
{
    public function testIsCompanyValid(): void
    {
        $traderDataValidator = new TraderDataValidator();
        $response = $traderDataValidator->isCompanyValid(true);
        
        static::assertEquals(true, $response);
    }

    public function testIsCompanyNotValid(): void
    {
        $traderDataValidator = new TraderDataValidator();
        $response = $traderDataValidator->isCompanyValid(false);
        
        static::assertEquals(false, $response);
    }

    public function testIsCompanyNameValid(): void
    {
        $traderDataValidator = new TraderDataValidator();
        $response = $traderDataValidator->isCompanyNameValid('Name');
        
        static::assertEquals(true, $response);
    }

    public function testIsCompanyNameNotValid(): void
    {
        $traderDataValidator = new TraderDataValidator();
        $response = $traderDataValidator->isCompanyNameValid('---');
        
        static::assertEquals(false, $response);
    }

    public function testIsCompanyAddressValid(): void
    {
        $traderDataValidator = new TraderDataValidator();
        $response = $traderDataValidator->isCompanyAddressValid('Address');
        
        static::assertEquals(true, $response);
    }

    public function testIsCompanyAddressNotValid(): void
    {
        $traderDataValidator = new TraderDataValidator();
        $response = $traderDataValidator->isCompanyAddressValid('---');
        
        static::assertEquals(false, $response);
    }
}