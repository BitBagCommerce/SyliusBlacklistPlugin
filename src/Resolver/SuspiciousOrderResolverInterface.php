<?php

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;

interface SuspiciousOrderResolverInterface
{
    public function resolve(FraudSuspicionInterface $fraudSuspicion);
}