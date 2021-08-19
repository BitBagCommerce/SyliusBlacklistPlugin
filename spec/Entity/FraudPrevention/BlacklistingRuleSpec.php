<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRule;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Customer\Model\CustomerGroupInterface;

final class BlacklistingRuleSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(BlacklistingRule::class);
    }

    function it_implements_blacklisting_rule_interface(): void
    {
        $this->shouldHaveType(BlacklistingRuleInterface::class);
    }

    function it_has_null_id_by_default(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_name_by_default(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_empty_array_of_attributes_by_default(): void
    {
        $this->getAttributes()->shouldReturn([]);
    }

    function it_has_no_permitted_strikes_by_default(): void
    {
        $this->getPermittedStrikes()->shouldReturn(null);
    }

    function it_has_empty_collection_of_channels_by_default(): void
    {
        $this->getChannels()->isEmpty()->shouldReturn(true);
    }

    function it_has_empty_collection_of_customer_groups_by_default(): void
    {
        $this->getCustomerGroups()->isEmpty()->shouldReturn(true);
    }

    function it_adds_channel(ChannelInterface $channel): void
    {
        $this->hasChannel($channel)->shouldReturn(false);

        $this->addChannel($channel);

        $this->getChannels()->contains($channel)->shouldReturn(true);
    }

    function it_adds_customer_groups(CustomerGroupInterface $customerGroup): void
    {
        $this->hasCustomerGroup($customerGroup)->shouldReturn(false);

        $this->addCustomerGroup($customerGroup);

        $this->hasCustomerGroup($customerGroup)->shouldReturn(true);
    }

    function it_has_for_unassigned_customers_set_on_false_by_default(): void
    {
        $this->isForUnassignedCustomers()->shouldReturn(false);
    }

    function it_sets_for_unassigned_customers(): void
    {
        $this->isForUnassignedCustomers()->shouldReturn(false);

        $this->setForUnassignedCustomers(true);

        $this->isForUnassignedCustomers()->shouldReturn(true);
    }
}
