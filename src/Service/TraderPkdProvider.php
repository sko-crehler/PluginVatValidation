<?php

namespace Plugin\VatValidation\Service;

use Plugin\VatValidation\PluginVatValidation;
use Psr\Log\LoggerInterface;
use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class TraderPkdProvider implements TraderPkdProviderInterface
{
    private const TIMEOUT = 5;

    private EntityRepositoryInterface $customerRepository;
    private \GuzzleHttp\Client $client;
    private LoggerInterface $logger;
    private SystemConfigService $systemConfigService;

    public function __construct(
        EntityRepositoryInterface $customerRepository,
        LoggerInterface $logger,
        SystemConfigService $systemConfigService
    )
    {
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
        $this->systemConfigService = $systemConfigService;
        $this->client = new \GuzzleHttp\Client();
    }

    public function handleTraderPkd(CustomerEntity $customer, Context $context): bool
    {
        if (empty($vatIds = $customer->getVatIds())) {
            return true;
        }
        $isPartialSuccess = false;
        foreach ($vatIds as $vatId) {
            try {
                $response = $this->client->get(PluginVatValidation::CEIDG_API_BASE_URL . 'firma', [
                    'query' => [
                        'nip' => mb_substr($vatId, 2)
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->systemConfigService->get('PluginVatValidation.config.apiKey')
                    ],
                    'timeout' => self::TIMEOUT,
                    'connect_timeout' => self::TIMEOUT
                ]);
                if ($response->getStatusCode() !== 200) {
                    continue;
                }
                $response = json_decode($response->getBody(), true);
                $this->parseAndSaveTraderPkd($response['firma'][0], $context, $customer->getId());
                $isPartialSuccess = true;
            } catch (\Throwable $exception) {
                $this->logger->error($exception->getMessage());
                return false;
            }
        }
        return $isPartialSuccess;
    }

    private function parseAndSaveTraderPkd(array $company, Context $context, string $customerId): void
    {
        foreach ($company['pkd'] as $pkdCode) {
            $this->customerRepository->upsert([[
                'id' => $customerId,
                'pkdCodes' => [['pkdCode' => $pkdCode]]
            ]], $context);
        }
    }
}