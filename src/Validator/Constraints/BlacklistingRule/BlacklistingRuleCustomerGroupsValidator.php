<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Validator\Constraints\BlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

class BlacklistingRuleCustomerGroupsValidator extends ConstraintValidator
{
    public function validate($blacklistingRule, Constraint $constraint): void
    {
        Assert::isInstanceOf($blacklistingRule, BlacklistingRuleInterface::class);

        if ($blacklistingRule->isOnlyForGuests() && !$blacklistingRule->getCustomerGroups()->isEmpty()) {
            $this->context->buildViolation($constraint->message)->addViolation();

            return;
        }
    }
}
