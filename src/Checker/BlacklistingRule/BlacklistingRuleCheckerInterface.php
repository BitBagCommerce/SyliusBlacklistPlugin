<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\Rule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;

interface BlacklistingRuleCheckerInterface
{
    public function checkIfCustomerIsBlacklisted(
        BlacklistingRuleInterface $blacklistingRule,
        FraudSuspicionInterface $newFraudSuspicion,
        array $fraudSuspicions
    ): bool;
}
