<?php declare(strict_types=1);
/**
 * Copyright (C) 2021 Adrian Pietrzak | www.pietrzakadrian.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\VatValidation\Service;

use Plugin\VatValidation\Dto\TraderDataResponseDto;
use Plugin\VatValidation\Exception\CompanyNoInformationException;
use Plugin\VatValidation\Exception\CompanyNotValidException;
use Plugin\VatValidation\Exception\ConnectErrorException;
use SoapClient;
use SoapFault;

class CheckVatService
{
    private const EC_URL = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    private TraderDataResponseDto $traderDataResponseDto;

    public function __construct()
    {
        $this->traderDataResponseDto = new TraderDataResponseDto();
    }

    public function fetchTraderData(string $requestedVatId): TraderDataResponseDto
    {
        $client = new SoapClient(self::EC_URL);

        if (!$client) {
            throw new ConnectErrorException();
        }

        $vatId = str_replace(array(' ', '.', '-', ',', ', '), '', trim($requestedVatId));
        $countryCode = substr($vatId, 0, 2);
        $vatNumber = substr($vatId, 2);
        $params = array('countryCode' => $countryCode, 'vatNumber' => $vatNumber);

        try {
            $loadedTrader = $client->checkVat($params);

            if (!$loadedTrader->valid) {
                throw new CompanyNotValidException();
            }

            if ($loadedTrader->name === "---" || $loadedTrader->address === "---") {
                throw new CompanyNoInformationException();
            }

            $this->traderDataResponseDto->setTraderName($loadedTrader->name);
            $this->traderDataResponseDto->setTraderAddress($loadedTrader->address);

            return $this->traderDataResponseDto;
        } catch (SoapFault $e) {
            throw new ConnectErrorException($e->getMessage());
        }
    }
}
