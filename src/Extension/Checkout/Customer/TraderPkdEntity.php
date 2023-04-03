<?php

namespace Plugin\VatValidation\Extension\Checkout\Customer;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class TraderPkdEntity extends Entity
{
    use EntityIdTrait;

    protected string $customerId;
    protected string $pkdCode;

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId(string $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return string
     */
    public function getPkdCode(): string
    {
        return $this->pkdCode;
    }

    /**
     * @param string $pkdCode
     */
    public function setPkdCode(string $pkdCode): void
    {
        $this->pkdCode = $pkdCode;
    }
}