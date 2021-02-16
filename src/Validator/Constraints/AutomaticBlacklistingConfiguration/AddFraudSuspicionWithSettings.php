<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration;

use Symfony\Component\Validator\Constraint;

class AddFraudSuspicionWithSettings extends Constraint
{
    public $message = 'bitbag_sylius_blacklist_plugin.automatic_blacklisting_configuration.add_settings';

    /** @var array */
    public $options;

    public function validatedBy(): string
    {
        return AddFraudSuspicionWithSettingsValidator::class;
    }

    public function getTargets(): array
    {
        return [self::CLASS_CONSTRAINT];
    }
}
