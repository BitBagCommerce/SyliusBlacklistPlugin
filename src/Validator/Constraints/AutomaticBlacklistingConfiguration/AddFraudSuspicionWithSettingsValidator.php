<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

final class AddFraudSuspicionWithSettingsValidator extends ConstraintValidator
{
    public function validate($automaticBlacklistingConfiguration, Constraint $constraint): void
    {
        Assert::isInstanceOf($automaticBlacklistingConfiguration, AutomaticBlacklistingConfigurationInterface::class);

        if (!$automaticBlacklistingConfiguration->isAddFraudSuspicion()) {
            return;
        }

        if (
            null === $automaticBlacklistingConfiguration->getPermittedFraudSuspicionCount() ||
            0 === $automaticBlacklistingConfiguration->getPermittedFraudSuspicionCount()
        ) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }

        if (null === $automaticBlacklistingConfiguration->getPermittedFraudSuspicionTime()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
