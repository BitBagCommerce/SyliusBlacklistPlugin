<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
