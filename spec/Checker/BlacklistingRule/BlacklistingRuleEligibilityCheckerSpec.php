<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule;

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
    ): void
    {
        $blacklistingRule->isOnlyForGuests()->willReturn(true);
        $customer->getUser()->willReturn($shopUser);

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $customer->getUser()->shouldBeCalled();

        $this->isEligible($blacklistingRule, $customer)->shouldReturn(false);
    }

    function it_returns_false_if_blacklisting_rule_is_not_eligible_due_to_customer_group(
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer,
        CustomerGroupInterface $customerGroup,
        CustomerGroupInterface $otherCustomerGroup
    ): void
    {
        $customerGroups = new ArrayCollection([$customerGroup->getWrappedObject()]);

        $blacklistingRule->isOnlyForGuests()->willReturn(false);
        $blacklistingRule->getCustomerGroups()->willReturn($customerGroups);
        $customer->getGroup()->willReturn($otherCustomerGroup);
        $blacklistingRule->hasCustomerGroup($otherCustomerGroup)->willReturn(false);

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $blacklistingRule->getCustomerGroups()->shouldBeCalled();
        $customer->getGroup()->shouldBeCalled();
        $blacklistingRule->hasCustomerGroup($otherCustomerGroup)->shouldBeCalled();

        $this->isEligible($blacklistingRule, $customer)->shouldReturn(false);
    }

    function it_returns_true_if_blacklisting_rule_is_eligible(
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer
    ): void
    {
        $blacklistingRule->isOnlyForGuests()->willReturn(false);
        $blacklistingRule->getCustomerGroups()->willReturn(new ArrayCollection());

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $blacklistingRule->getCustomerGroups()->shouldBeCalled();

        $this->isEligible($blacklistingRule, $customer)->shouldReturn(true);
    }
}
