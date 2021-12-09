<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Service;

use Plugin\VatValidation\Dto\TraderDataRequestDto;
use Plugin\VatValidation\Dto\TraderDataResponseDto;

class CheckVatService implements CheckVatServiceInterface
{
    private TraderDataRequestDto $traderDataRequestDto;

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->traderDataRequestDto = new TraderDataRequestDto();
    }

    public function fetchTraderData(string $requestedVatId): ?TraderDataResponseDto
    {
        $vatId = str_replace(array(' ', '.', '-', ',', ', '), '', trim($requestedVatId));
        $countryCode = substr($vatId, 0, 2);
        $vatNumber = substr($vatId, 2);

        $this->traderDataRequestDto->setCountryCode($countryCode);
        $this->traderDataRequestDto->setVatNumber($vatNumber);

        return $this->client->check($this->traderDataRequestDto);
    }
}
