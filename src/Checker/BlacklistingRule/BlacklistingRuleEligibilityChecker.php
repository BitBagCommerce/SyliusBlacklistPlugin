<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

final class BlacklistingRuleEligibilityChecker implements BlacklistingRuleEligibilityCheckerInterface
{
    public function isEligible(BlacklistingRuleInterface $blacklistingRule, CustomerInterface $customer): bool
    {
        if ($blacklistingRule->isOnlyForGuests() && null !== $customer->getUser()) {
            return false;
        }

        $customerGroup = $customer->getGroup();

        if (null !== $customerGroup) {
            if ($blacklistingRule->getCustomerGroups()->isEmpty() && $blacklistingRule->isForUnassignedCustomers()) {
                return false;
            }

            if (!$blacklistingRule->getCustomerGroups()->isEmpty()) {
                return $blacklistingRule->hasCustomerGroup($customerGroup);
            }

            return true;
        }

        return !$blacklistingRule->getCustomerGroups()->isEmpty() && !$blacklistingRule->isForUnassignedCustomers() ? false : true;
    }
}
