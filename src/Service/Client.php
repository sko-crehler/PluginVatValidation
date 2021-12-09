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
use Plugin\VatValidation\Exception\CompanyNoInformationException;
use Plugin\VatValidation\Exception\CompanyNotValidException;
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

    public function check(TraderDataRequestDto $traderDataRequestDto): ?TraderDataResponseDto
    {
        $client = new SoapClient(self::EC_URL);

        if (!$client) {
            throw new ConnectErrorException();
        }

        try {
            $loadedTrader = $client->checkVat($traderDataRequestDto);

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