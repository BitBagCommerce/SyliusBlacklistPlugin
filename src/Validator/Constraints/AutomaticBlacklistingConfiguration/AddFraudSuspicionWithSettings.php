<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration;

use Symfony\Component\Validator\Constraint;

final class AddFraudSuspicionWithSettings extends Constraint
{
    public $fraudSuspicionsNumberNotBlankMessage = 'bitbag_sylius_blacklist_plugin.automatic_blacklisting_configuration.fraud_suspicions_number.not_blank';

    public $fraudSuspicionTimeNotBlankMessage = 'bitbag_sylius_blacklist_plugin.automatic_blacklisting_configuration.fraud_suspicions_time.not_blank';

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
