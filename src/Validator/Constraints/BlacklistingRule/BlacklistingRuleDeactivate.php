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

class BlacklistingRuleDeactivate extends Constraint
{
    public $message = 'bitbag_sylius_blacklist_plugin.form.error.cannot_deactivate_manual_blacklisting_rule';

    /** @var array */
    public $options;

    public function validatedBy(): string
    {
        return BlacklistingRuleDeactivateValidator::class;
    }

    public function getTargets(): array
    {
        return [self::PROPERTY_CONSTRAINT];
    }
}
