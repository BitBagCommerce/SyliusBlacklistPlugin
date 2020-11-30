<?php

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;

interface AddressTypeResolverInterface
{
    public function resolveAndUpdateFraudSuspicion(FraudSuspicionInterface $fraudSuspicion): void;
}