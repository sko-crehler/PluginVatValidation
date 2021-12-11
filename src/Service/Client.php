<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Service;

use SoapClient;
use SoapFault;
use Plugin\VatValidation\Exception\ConnectErrorException;
use Plugin\VatValidation\Dto\TraderDataRequestDto;
use Plugin\VatValidation\Dto\TraderDataResponseDto;

class Client implements ClientInterface
{
    private const EC_URL = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    private TraderDataResponseDto $traderDataResponseDto;

    public function __construct()
    {
        $this->traderDataResponseDto = new TraderDataResponseDto();
    }

    public function check(TraderDataRequestDto $traderDataRequestDto): TraderDataResponseDto
    {
        $client = new SoapClient(self::EC_URL);

        if (!$client) {
            throw new ConnectErrorException();
        }

        try {
            $loadedTrader = $client->checkVat($traderDataRequestDto);

            $this->traderDataResponseDto->setName($loadedTrader->name);
            $this->traderDataResponseDto->setAddress($loadedTrader->address);
            $this->traderDataResponseDto->setVatNumber($loadedTrader->vatNumber);
            $this->traderDataResponseDto->setRequestDate($loadedTrader->requestDate);
            $this->traderDataResponseDto->setValid($loadedTrader->valid);
            $this->traderDataResponseDto->setCountryCode($loadedTrader->countryCode);

            return $this->traderDataResponseDto;
        } catch (SoapFault $e) {
            throw new ConnectErrorException($e->getMessage());
        }
    }
}