<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
