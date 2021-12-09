<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Response;

use Plugin\VatValidation\Struct\TraderStruct;
use Shopware\Core\System\SalesChannel\StoreApiResponse;

class VatValidationResponse extends StoreApiResponse
{
    /**
     * @var TraderStruct
     */
    protected $object;

    public function __construct(TraderStruct $object)
    {
        parent::__construct($object);
    }

    public function getResult(): TraderStruct
    {
        return $this->object;
    }
}