<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Service;

class TraderDataValidator implements TraderDataValidatorInterface
{
    public function isCompanyNameValid(string $name): bool
    {
        if ($name === "---" || !$name) {
            return false;
        }

        return true;
    }

    public function isCompanyAddressValid(string $address): bool
    {
        if ($address === "---" || !$address) {
            return false;
        }

        return true;
    }

    public function isCompanyValid(bool $valid): bool
    {
        if (!$valid) {
            return false;
        }

        return true;
    }
}