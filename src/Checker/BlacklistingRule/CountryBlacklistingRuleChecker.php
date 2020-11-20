<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Checker\Rule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;

class CountryBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    public function checkIfCustomerIsBlacklisted(
        BlacklistingRuleInterface $blacklistingRule,
        FraudSuspicionInterface $newFraudSuspicion,
        array $fraudSuspicions
    ): bool {
        if (!\in_array('customer_id', $blacklistingRule->getAttributes())) {
            $maxPermittedStrikes = 0;

            foreach ($fraudSuspicions as $fraudSuspicion) {
                if ($newFraudSuspicion->getCountry() === $fraudSuspicion->getCountry()) {
                    $maxPermittedStrikes++;
                }
            }

            if ($maxPermittedStrikes >= $blacklistingRule->getPermittedStrikes()) {
                return true;
            }
        }

        return false;
    }
}