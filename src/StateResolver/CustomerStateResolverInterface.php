<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\StateResolver;

use Sylius\Component\Customer\Model\CustomerInterface;

interface CustomerStateResolverInterface
{
    public function changeStateOnBlacklisted(CustomerInterface $customer): void;
}