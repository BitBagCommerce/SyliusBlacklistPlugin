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
    public function validate(mixed $automaticBlacklistingConfiguration, Constraint $constraint): void
    {
        Assert::isInstanceOf($automaticBlacklistingConfiguration, AutomaticBlacklistingConfigurationInterface::class);

        if (!$automaticBlacklistingConfiguration->isAddFraudSuspicion()) {
            return;
        }

        if (
            null === $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber() ||
            0 === $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()
        ) {
            $this->context
                ->buildViolation($constraint->fraudSuspicionsNumberNotBlankMessage)
                ->atPath('permittedFraudSuspicionsNumber')
                ->addViolation()
            ;
        }

        if (null === $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime()) {
            $this->context
                ->buildViolation($constraint->fraudSuspicionTimeNotBlankMessage)
                ->atPath('permittedFraudSuspicionsTime')
                ->addViolation()
            ;
        }
    }
}
