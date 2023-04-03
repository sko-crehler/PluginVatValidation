<?php

namespace Plugin\VatValidation\Subscriber;

use Shopware\Core\Checkout\Customer\Event\CustomerRegisterEvent;
use Shopware\Core\Checkout\Customer\Event\GuestCustomerRegisterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TraderPkdSubscriber implements EventSubscriberInterface
{
    private array $providers;

    public function __construct(iterable $providers)
    {
        $this->providers = $providers instanceof \Traversable ? iterator_to_array($providers) : $providers;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            CustomerRegisterEvent::class => 'savePkdCodes',
            GuestCustomerRegisterEvent::class => 'savePkdCodes'
        ];
    }

    public function savePkdCodes(CustomerRegisterEvent $event): void
    {
        foreach ($this->providers as $provider) {
            if ($provider->handleTraderPkd($event->getCustomer(), $event->getContext())) {
                return;
            }
        }
    }
}