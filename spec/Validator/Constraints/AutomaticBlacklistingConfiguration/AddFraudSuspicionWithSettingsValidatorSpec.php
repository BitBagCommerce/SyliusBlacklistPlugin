<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);
namespace spec\BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration\AddFraudSuspicionWithSettings;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration\AddFraudSuspicionWithSettingsValidator;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

final class AddFraudSuspicionWithSettingsValidatorSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(AddFraudSuspicionWithSettingsValidator::class);
    }

    function it_extends_constraint_validator_class(): void
    {
        $this->shouldHaveType(ConstraintValidator::class);
    }

    function it_does_not_block(AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration): void
    {
        $constraint = new AddFraudSuspicionWithSettings();

        $automaticBlacklistingConfiguration->isAddFraudSuspicion()->willReturn(false);

        $automaticBlacklistingConfiguration->isAddFraudSuspicion()->shouldBeCalled();

        $this->validate($automaticBlacklistingConfiguration, $constraint)->shouldReturn(null);
    }

    function it_blocks_if_there_are_missing_data(
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration,
        ExecutionContextInterface $context,
        ConstraintViolationBuilderInterface $constraintViolationBuilder,
        ConstraintViolationBuilderInterface $secondConstraintViolationBuilder
    ): void {
        $constraint = new AddFraudSuspicionWithSettings();

        $automaticBlacklistingConfiguration->isAddFraudSuspicion()->willReturn(true);
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()->willReturn(null);
        $context->buildViolation('bitbag_sylius_blacklist_plugin.automatic_blacklisting_configuration.fraud_suspicions_number.not_blank')->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder->atPath('permittedFraudSuspicionsNumber')->willReturn($constraintViolationBuilder);
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime()->willReturn(null);
        $context->buildViolation('bitbag_sylius_blacklist_plugin.automatic_blacklisting_configuration.fraud_suspicions_time.not_blank')->willReturn($secondConstraintViolationBuilder);
        $secondConstraintViolationBuilder->atPath('permittedFraudSuspicionsTime')->willReturn($secondConstraintViolationBuilder);

        $automaticBlacklistingConfiguration->isAddFraudSuspicion()->shouldBeCalled();
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()->shouldBeCalled();
        $context->buildViolation('bitbag_sylius_blacklist_plugin.automatic_blacklisting_configuration.fraud_suspicions_number.not_blank')->shouldBeCalled();
        $constraintViolationBuilder->atPath('permittedFraudSuspicionsNumber')->shouldBeCalled();
        $constraintViolationBuilder->addViolation()->shouldBeCalled();
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime()->shouldBeCalled();
        $context->buildViolation('bitbag_sylius_blacklist_plugin.automatic_blacklisting_configuration.fraud_suspicions_time.not_blank')->shouldBeCalled();
        $secondConstraintViolationBuilder->atPath('permittedFraudSuspicionsTime')->shouldBeCalled();
        $secondConstraintViolationBuilder->addViolation()->shouldBeCalled();

        $this->initialize($context);
        $this->validate($automaticBlacklistingConfiguration, $constraint)->shouldReturn(null);
    }
}
