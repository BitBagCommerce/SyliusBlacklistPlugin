<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);
namespace spec\BitBag\SyliusBlacklistPlugin\Validator\Constraints\BlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\BlacklistingRule\BlacklistingRuleCustomerGroups;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\BlacklistingRule\BlacklistingRuleCustomerGroupsValidator;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Customer\Model\CustomerGroupInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

final class BlacklistingRuleCustomerGroupsValidatorSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(BlacklistingRuleCustomerGroupsValidator::class);
    }

    function it_extends_constraint_validator_class(): void
    {
        $this->shouldHaveType(ConstraintValidator::class);
    }

    function it_blocks_if_admin_try_mark_groups_and_it_is_rule_only_for_guests(
        BlacklistingRuleInterface $blacklistingRule,
        CustomerGroupInterface $customerGroup,
        ExecutionContextInterface $context,
        ConstraintViolationBuilderInterface $constraintViolationBuilder
    ): void {
        $constraint = new BlacklistingRuleCustomerGroups();

        $customerGroups = new ArrayCollection([$customerGroup]);

        $blacklistingRule->isOnlyForGuests()->willReturn(true);
        $blacklistingRule->getCustomerGroups()->willReturn($customerGroups);
        $context->buildViolation('bitbag_sylius_blacklist_plugin.blacklisting_rule.guests_cannot_have_group')->willReturn($constraintViolationBuilder);

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $blacklistingRule->getCustomerGroups()->shouldBeCalled();
        $context->buildViolation('bitbag_sylius_blacklist_plugin.blacklisting_rule.guests_cannot_have_group')->shouldBeCalled();
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $this->initialize($context);
        $this->validate($blacklistingRule, $constraint);
    }

    function it_does_not_block_if_it_is_rule_only_for_guests_and_it_has_no_groups_marked(BlacklistingRuleInterface $blacklistingRule): void
    {
        $constraint = new BlacklistingRuleCustomerGroups();

        $blacklistingRule->isOnlyForGuests()->willReturn(true);
        $blacklistingRule->getCustomerGroups()->willReturn(new ArrayCollection());

        $blacklistingRule->isOnlyForGuests()->shouldBeCalled();
        $blacklistingRule->getCustomerGroups()->shouldBeCalled();

        $this->validate($blacklistingRule, $constraint);
    }
}
