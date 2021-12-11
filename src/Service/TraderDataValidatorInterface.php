<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Service;

interface TraderDataValidatorInterface
{
    public function isCompanyNameValid(string $name): bool;

    public function isCompanyAddressValid(string $address): bool;

    public function isCompanyValid(bool $valid): bool;
}