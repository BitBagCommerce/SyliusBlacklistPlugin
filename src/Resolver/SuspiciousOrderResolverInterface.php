<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;

interface SuspiciousOrderResolverInterface
{
    public function resolve(FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): bool;
}