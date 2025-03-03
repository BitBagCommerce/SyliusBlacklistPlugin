<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Validator\Constraints\BlacklistingRule;

use Symfony\Component\Validator\Constraint;

class BlacklistingRuleCustomerGroups extends Constraint
{
    public string $message = 'bitbag_sylius_blacklist_plugin.blacklisting_rule.guests_cannot_have_group';

    /** @var array */
    public $options;

    public function validatedBy(): string
    {
        return BlacklistingRuleCustomerGroupsValidator::class;
    }

    /**
     * @return array{'class'|'property'}
     */
    public function getTargets(): array
    {
        return [self::CLASS_CONSTRAINT];
    }
}
