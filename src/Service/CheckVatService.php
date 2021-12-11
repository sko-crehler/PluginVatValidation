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
use Plugin\VatValidation\Exception\CompanyNoInformationException;
use Plugin\VatValidation\Exception\CompanyNotValidException;
use Plugin\VatValidation\Struct\TraderStruct;

class CheckVatService implements CheckVatInterface
{
    private TraderDataRequestDto $traderDataRequestDto;

    private TraderDataValidatorInterface $traderDataValidator;

    private TraderStruct $traderStruct;

    private ClientInterface $client;

    public function __construct(ClientInterface $client, TraderDataValidatorInterface $traderDataValidator)
    {
        $this->client = $client;
        $this->traderDataValidator = $traderDataValidator;
        $this->traderDataRequestDto = new TraderDataRequestDto();
        $this->traderStruct = new TraderStruct();
    }

    public function handleTraderData(string $requestVatId): TraderStruct
    {
        $traderData = $this->fetchTraderData($requestVatId);

        $this->validateTraderData($traderData);

        return $this->saveTraderData($traderData);
    }

    private function fetchTraderData(string $requestedVatId): TraderDataResponseDto
    {
        $vatId = str_replace(array(' ', '.', '-', ',', ', '), '', trim($requestedVatId));
        $countryCode = substr($vatId, 0, 2);
        $vatNumber = substr($vatId, 2);

        $this->traderDataRequestDto->setCountryCode($countryCode);
        $this->traderDataRequestDto->setVatNumber($vatNumber);

        return $this->client->check($this->traderDataRequestDto);
    }

    private function saveTraderData(TraderDataResponseDto $traderDataResponseDto): TraderStruct
    {
        $this->traderStruct->setTraderName($traderDataResponseDto->getName());
        $this->traderStruct->setTraderAddress($traderDataResponseDto->getAddress());

        return $this->traderStruct;
    }

    private function validateTraderData(TraderDataResponseDto $traderDataResponseDto): void {
        if (!$this->traderDataValidator->isCompanyAddressValid($traderDataResponseDto->getAddress())) {
            throw new CompanyNoInformationException();
        }

        if (!$this->traderDataValidator->isCompanyNameValid($traderDataResponseDto->getName())) {
            throw new CompanyNoInformationException();
        }

        if (!$this->traderDataValidator->isCompanyValid($traderDataResponseDto->isValid())) {
            throw new CompanyNotValidException();
        }
    }
}
