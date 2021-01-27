<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Validator\Constraints\BlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\BlacklistingRule\BlacklistingRuleDeactivate;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\BlacklistingRule\BlacklistingRuleDeactivateValidator;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

final class BlacklistingRuleDeactivateValidatorSpec extends ObjectBehavior
{
    function let(
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext
    ) {
        $this->beConstructedWith(
            $automaticBlacklistingConfigurationRepository,
            $blacklistingRuleRepository,
            $channelContext
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(BlacklistingRuleDeactivateValidator::class);
    }

    function it_extends_constraint_validator_class(): void
    {
        $this->shouldHaveType(ConstraintValidator::class);
    }

    function it_validates(
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        BlacklistingRuleInterface $blacklistingRule,
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration,
        ExecutionContextInterface $context,
        ConstraintViolationBuilderInterface $constraintViolationBuilder
    ): void {
        $constraint = new BlacklistingRuleDeactivate();

        $channelContext->getChannel()->willReturn($channel);
        $blacklistingRuleRepository->findActiveByChannel($channel)->willReturn([$blacklistingRule]);
        $automaticBlacklistingConfigurationRepository->findActiveByChannelWithAddingRowsToFraudSuspicion($channel)->willReturn([$automaticBlacklistingConfiguration]);
        $context->buildViolation('bitbag_sylius_blacklist_plugin.form.error.cannot_deactivate_manual_blacklisting_rule')->willReturn($constraintViolationBuilder);

        $channelContext->getChannel()->shouldBeCalled();
        $blacklistingRuleRepository->findActiveByChannel($channel)->shouldBeCalled();
        $automaticBlacklistingConfigurationRepository->findActiveByChannelWithAddingRowsToFraudSuspicion($channel)->shouldBeCalled();
        $context->buildViolation('bitbag_sylius_blacklist_plugin.form.error.cannot_deactivate_manual_blacklisting_rule')->shouldBeCalled();
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $this->initialize($context);
        $this->validate(false, $constraint)->shouldReturn(null);
    }

    function it_does_not_validate(
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        BlacklistingRuleInterface $blacklistingRule
    ): void {
        $constraint = new BlacklistingRuleDeactivate();

        $channelContext->getChannel()->willReturn($channel);
        $blacklistingRuleRepository->findActiveByChannel($channel)->willReturn([$blacklistingRule]);
        $automaticBlacklistingConfigurationRepository->findActiveByChannelWithAddingRowsToFraudSuspicion($channel)->willReturn([]);

        $this->validate(false, $constraint)->shouldReturn(null);
    }
}
