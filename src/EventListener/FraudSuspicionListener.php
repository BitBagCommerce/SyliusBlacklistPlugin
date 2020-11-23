<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\EventListener;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolver;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolver;
use Symfony\Component\EventDispatcher\GenericEvent;

class FraudSuspicionListener
{
    /** @var SuspiciousOrderResolver */
    private $suspiciousOrderResolver;

    /** @var CustomerStateResolver */
    private $customerStateResolver;

    public function __construct(SuspiciousOrderResolverInterface $suspiciousOrderResolver, CustomerStateResolver $customerStateResolver)
    {
        $this->suspiciousOrderResolver = $suspiciousOrderResolver;
        $this->customerStateResolver = $customerStateResolver;
    }

    public function processSuspicionOrder(GenericEvent $event): void
    {
        /** @var FraudSuspicionInterface $newFraudSuspicion */
        $newFraudSuspicion = $event->getSubject();

        if ($this->suspiciousOrderResolver->resolve($newFraudSuspicion->getOrder())) {
            $this->customerStateResolver->changeStateOnBlacklisted($newFraudSuspicion->getOrder()->getCustomer());
        }
    }
}