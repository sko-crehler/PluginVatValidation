<?php

namespace Plugin\VatValidation\Extension\Checkout\Customer;

use Shopware\Core\Checkout\Customer\CustomerDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class TraderPkdExtension extends EntityExtension
{

    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField('pkdCodes', TraderPkdDefinition::class, 'customer_id')
        );
    }

    /**
     * @inheritDoc
     */
    public function getDefinitionClass(): string
    {
        return CustomerDefinition::class;
    }
}