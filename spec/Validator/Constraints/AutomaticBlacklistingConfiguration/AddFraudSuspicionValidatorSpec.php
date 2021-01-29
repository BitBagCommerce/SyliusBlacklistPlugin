<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration\AddFraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration\AddFraudSuspicionValidator;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

final class AddFraudSuspicionByAutomaticBlacklistingConfigurationValidatorSpec extends ObjectBehavior
{
    function let(
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext
    ) {
        $this->beConstructedWith($blacklistingRuleRepository, $channelContext);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AddFraudSuspicionValidator::class);
    }

    function it_extends_constraint_validator_class(): void
    {
        $this->shouldHaveType(ConstraintValidator::class);
    }

    function it_validates(
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        ExecutionContextInterface $context,
        ConstraintViolationBuilderInterface $constraintViolationBuilder
    ): void {
        $constraint = new AddFraudSuspicion();

        $channelContext->getChannel()->willReturn($channel);
        $blacklistingRuleRepository->findActiveByChannel($channel)->willReturn([]);
        $context->buildViolation('bitbag_sylius_blacklist_plugin.form.error.cannot_add_automatic_blacklisting_configuration')->willReturn($constraintViolationBuilder);

        $channelContext->getChannel()->shouldBeCalled();
        $blacklistingRuleRepository->findActiveByChannel($channel)->shouldBeCalled();
        $context->buildViolation('bitbag_sylius_blacklist_plugin.form.error.cannot_add_automatic_blacklisting_configuration')->shouldBeCalled();
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $this->initialize($context);
        $this->validate(true, $constraint)->shouldReturn(null);
    }

    function it_does_not_validate(
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        BlacklistingRuleInterface $blacklistingRule
    ): void
    {
        $constraint = new AddFraudSuspicion();

        $channelContext->getChannel()->willReturn($channel);
        $blacklistingRuleRepository->findActiveByChannel($channel)->willReturn([$blacklistingRule]);

        $channelContext->getChannel()->willReturn($channel);
        $blacklistingRuleRepository->findActiveByChannel($channel)->willReturn([$blacklistingRule]);

        $this->validate(true, $constraint)->shouldReturn(null);
    }
}
