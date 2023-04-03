<?php

namespace Plugin\VatValidation\Service;

use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Framework\Context;

interface TraderPkdProviderInterface
{
    public function handleTraderPkd(CustomerEntity $customer, Context $context): bool;
}