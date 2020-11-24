<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\EventListener;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class FraudSuspicionListener
{
    /** @var SuspiciousOrderResolverInterface */
    private $suspiciousOrderResolver;

    /** @var CustomerStateResolverInterface */
    private $customerStateResolver;

    public function __construct(SuspiciousOrderResolverInterface $suspiciousOrderResolver, CustomerStateResolverInterface $customerStateResolver)
    {
        $this->suspiciousOrderResolver = $suspiciousOrderResolver;
        $this->customerStateResolver = $customerStateResolver;
    }

    public function processSuspicionOrder(GenericEvent $event): void
    {
        /** @var FraudSuspicionInterface $newFraudSuspicion */
        $newFraudSuspicion = $event->getSubject();

        if ($this->suspiciousOrderResolver->resolve($newFraudSuspicion->getOrder(), $newFraudSuspicion->getAddressType())) {
            $this->customerStateResolver->changeStateOnBlacklisted($newFraudSuspicion->getOrder()->getCustomer());
        }
    }
}