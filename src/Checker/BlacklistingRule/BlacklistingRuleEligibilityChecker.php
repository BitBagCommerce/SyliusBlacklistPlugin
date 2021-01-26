<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

final class BlacklistingRuleEligibilityChecker implements BlacklistingRuleEligibilityCheckerInterface
{
    public function isEligible(BlacklistingRuleInterface $blacklistingRule, CustomerInterface $customer): bool
    {
        if ($blacklistingRule->isOnlyForGuests() && $customer->getUser() !== null) {
            return false;
        }

        $customerGroup = $customer->getGroup();

        if ($customerGroup !== null) {
            if ($blacklistingRule->getCustomerGroups()->isEmpty() && $blacklistingRule->isForUnassignedCustomers()) {
                return false;
            }

            if (!$blacklistingRule->getCustomerGroups()->isEmpty()) {
                return $blacklistingRule->hasCustomerGroup($customerGroup);
            }

            return true;
        } else {
            return !$blacklistingRule->getCustomerGroups()->isEmpty() && !$blacklistingRule->isForUnassignedCustomers() ? false : true;
        }
    }
}