<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation;

use Shopware\Core\Framework\Plugin;

class PluginVatValidation extends Plugin
{
    public const CEIDG_API_BASE_URL = 'https://dane.biznes.gov.pl/api/ceidg/v2/';
}