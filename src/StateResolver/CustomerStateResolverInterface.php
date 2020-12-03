<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\StateResolver;

use Sylius\Component\Customer\Model\CustomerInterface;

interface CustomerStateResolverInterface
{
    public function changeStateOnBlacklisted(CustomerInterface $customer): void;
}