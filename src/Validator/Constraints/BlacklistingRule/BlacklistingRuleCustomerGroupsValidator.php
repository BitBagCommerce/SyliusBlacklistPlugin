<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
        }
    }
}
