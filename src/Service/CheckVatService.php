<?php declare(strict_types=1);

namespace SwagExample\Service;

use SoapClient;
use SoapFault;
use SwagExample\Dto\TraderDataResponseDto;
use SwagExample\Exception\CompanyNoInformationException;
use SwagExample\Exception\CompanyNotValidException;
use SwagExample\Exception\ConnectErrorException;

class CheckVatService
{
    private const EC_URL = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    private TraderDataResponseDto $traderDataResponseDto;

    public function __construct()
    {
        $this->traderDataResponseDto = new TraderDataResponseDto();
    }

    public function fetchTraderData($requestedVatId): ?TraderDataResponseDto
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
            $response = $client->checkVat($params);

            if (!$response->valid) {
                throw new CompanyNotValidException();
            }

            if ($response->name === "---" || $response->address === "---") {
                throw new CompanyNoInformationException();
            }

            $this->traderDataResponseDto->setTraderName($response->name);
            $this->traderDataResponseDto->setTraderAddress($response->address);

            return $this->traderDataResponseDto;
        } catch (SoapFault $e) {
            throw new ConnectErrorException($e->getMessage());
        }
    }
}
