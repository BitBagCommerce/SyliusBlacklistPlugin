<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\EventListener;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolver;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class FraudSuspicionListener
{
    /** @var SuspiciousOrderResolver */
    private $suspiciousOrderResolver;

    public function __construct(SuspiciousOrderResolverInterface $suspiciousOrderResolver)
    {
        $this->suspiciousOrderResolver = $suspiciousOrderResolver;
    }

    public function processSuspicionOrder(GenericEvent $event): void
    {
        /** @var FraudSuspicionInterface $newFraudSuspicion */
        $newFraudSuspicion = $event->getSubject();

        $this->suspiciousOrderResolver->resolve($newFraudSuspicion);
    }
}