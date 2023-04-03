<?php

namespace Plugin\VatValidation\Service;

use Plugin\VatValidation\Dto\TraderDataRequestDto;
use Plugin\VatValidation\Dto\TraderDataResponseDto;
use Plugin\VatValidation\PluginVatValidation;
use Psr\Log\LoggerInterface;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class CeidgProvider implements VatDataProviderInterface
{
    private const TIMEOUT = 5;

    private SystemConfigService $systemConfigService;
    private LoggerInterface $logger;
    private \GuzzleHttp\Client $client;

    public function __construct(SystemConfigService $systemConfigService, LoggerInterface $logger)
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
        $this->client = new \GuzzleHttp\Client();
    }

    public function check(TraderDataRequestDto $traderDataRequestDto): ?TraderDataResponseDto
    {
        if ($traderDataRequestDto->getCountryCode() !== 'PL') {
            return null;
        }
        try {
            $response = $this->client->get(PluginVatValidation::CEIDG_API_BASE_URL . 'firma', [
                'query' => [
                    'nip' => $traderDataRequestDto->getVatNumber()
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->systemConfigService->get('PluginVatValidation.config.apiKey')
                ],
                'timeout' => self::TIMEOUT,
                'connect_timeout' => self::TIMEOUT
            ]);
            if ($response->getStatusCode() !== 200) {
                return null;
            }
            $response = json_decode($response->getBody(), true);
            return $this->parseTraderData($response['firma'][0]);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
        return null;
    }

    private function companyAddressToString(array $companyAddress): string
    {
        return sprintf(
            "%s %s\n%s %s",
            $companyAddress['ulica'],
            $companyAddress['budynek'],
            $companyAddress['kod'],
            $companyAddress['miasto']
        );
    }

    private function parseTraderData(array $company): TraderDataResponseDto
    {
        $traderDataResponseDto = new TraderDataResponseDto();

        $traderDataResponseDto->setName($company['nazwa']);
        $traderDataResponseDto->setAddress($this->companyAddressToString($company['adresDzialalnosci']));
        $traderDataResponseDto->setCountryCode($company['adresDzialalnosci']['kraj']);
        $traderDataResponseDto->setVatNumber($company['wlasciciel']['nip']);
        $traderDataResponseDto->setRequestDate((new \DateTime('now'))->format('Y-m-d H:i:s'));
        $traderDataResponseDto->setValid(true);

        return $traderDataResponseDto;
    }
}