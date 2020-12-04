<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Validator\Constraints\Checkout;

use Symfony\Component\Validator\Constraint;

class CheckoutAddressType extends Constraint
{
    public $message = 'bitbag_sylius_blacklist_plugin.form.error.cannot_place_order';

    /** @var array */
    public $options;

    public function validatedBy(): string
    {
        return CheckoutAddressTypeValidator::class;
    }

    public function getTargets(): array
    {
        return [self::CLASS_CONSTRAINT];
    }
}
