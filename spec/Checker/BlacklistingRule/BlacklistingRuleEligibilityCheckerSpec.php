<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleEligibilityChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleEligibilityCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Customer\Model\CustomerGroupInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class BlacklistingRuleEligibilityCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(BlacklistingRuleEligibilityChecker::class);
    }

    function it_implements_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleEligibilityCheckerInterface::class);
    }

    function it_returns_false_if_blacklisting_rule_is_not_eligible_due_to_only_for_guests(
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer,
        ShopUserInterface $shopUser
    ): void {
        $blacklistingRule->isOnlyForGuests()->willReturn(true);
        $customer->getUser()->willReturn($shopUser);

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $customer->getUser()->shouldBeCalled();

        $this->isEligible($blacklistingRule, $customer)->shouldReturn(false);
    }

    function it_returns_false_if_blacklisting_rule_is_not_eligible_due_to_customer_group(
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer,
        CustomerGroupInterface $otherCustomerGroup
    ): void {
        $blacklistingRule->isOnlyForGuests()->willReturn(false);
        $customer->getGroup()->willReturn($otherCustomerGroup);
        $blacklistingRule->getCustomerGroups()->willReturn(new ArrayCollection());
        $blacklistingRule->isForUnassignedCustomers()->willReturn(true);

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $customer->getGroup()->shouldBeCalled();
        $blacklistingRule->getCustomerGroups()->shouldBeCalled();
        $blacklistingRule->isForUnassignedCustomers()->shouldBeCalled();

        $this->isEligible($blacklistingRule, $customer)->shouldReturn(false);
    }

    function it_returns_false_if_blacklisting_rule_does_not_contain_customer_group(
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer,
        CustomerGroupInterface $customerGroup,
        CustomerGroupInterface $otherCustomerGroup
    ): void {
        $blacklistingRuleCustomerGroups = new ArrayCollection([$customerGroup]);

        $blacklistingRule->isOnlyForGuests()->willReturn(false);
        $customer->getGroup()->willReturn($otherCustomerGroup);
        $blacklistingRule->getCustomerGroups()->willReturn($blacklistingRuleCustomerGroups);
        $blacklistingRule->hasCustomerGroup($otherCustomerGroup)->willReturn(false);

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $customer->getGroup()->shouldBeCalled();
        $blacklistingRule->getCustomerGroups()->shouldBeCalled();
        $blacklistingRule->hasCustomerGroup($otherCustomerGroup)->shouldBeCalled();

        $this->isEligible($blacklistingRule, $customer)->shouldReturn(false);
    }

    function it_returns_false_if_customer_has_no_group(
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer,
        CustomerGroupInterface $customerGroup
    ): void {
        $blacklistingRuleCustomerGroups = new ArrayCollection([$customerGroup]);

        $blacklistingRule->isOnlyForGuests()->willReturn(false);
        $customer->getGroup()->willReturn(null);
        $blacklistingRule->getCustomerGroups()->willReturn($blacklistingRuleCustomerGroups);
        $blacklistingRule->isForUnassignedCustomers()->willReturn(false);

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $customer->getGroup()->shouldBeCalled();
        $blacklistingRule->getCustomerGroups()->shouldBeCalled();
        $blacklistingRule->isForUnassignedCustomers()->shouldBeCalled();

        $this->isEligible($blacklistingRule, $customer)->shouldReturn(false);
    }

    function it_returns_true_if_customer_has_no_group(
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer,
        CustomerGroupInterface $customerGroup
    ): void {
        $blacklistingRule->isOnlyForGuests()->willReturn(false);
        $customer->getGroup()->willReturn(null);
        $blacklistingRule->getCustomerGroups()->willReturn(new ArrayCollection());

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $customer->getGroup()->shouldBeCalled();
        $blacklistingRule->getCustomerGroups()->shouldBeCalled();

        $this->isEligible($blacklistingRule, $customer)->shouldReturn(true);
    }

    function it_returns_true_if_blacklisting_rule_is_eligible(
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer,
        CustomerGroupInterface $customerGroup
    ): void {
        $blacklistingRule->isOnlyForGuests()->willReturn(false);
        $customer->getGroup()->willReturn($customerGroup);
        $blacklistingRule->getCustomerGroups()->willReturn(new ArrayCollection());
        $blacklistingRule->isForUnassignedCustomers()->willReturn(false);

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $customer->getGroup()->shouldBeCalled();
        $blacklistingRule->getCustomerGroups()->shouldBeCalled();
        $blacklistingRule->isForUnassignedCustomers()->shouldBeCalled();

        $this->isEligible($blacklistingRule, $customer)->shouldReturn(true);
    }
}
