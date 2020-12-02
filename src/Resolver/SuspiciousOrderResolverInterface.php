<?php

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;

interface SuspiciousOrderResolverInterface
{
    public function resolve(FraudSuspicionCommonModel $fraudSuspicionCommonModel): bool;
}