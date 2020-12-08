<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Sylius\Component\Core\Model\AddressInterface;

interface AddressTypeResolverInterface
{
    public function resolveAndUpdateFraudSuspicion(FraudSuspicionInterface $fraudSuspicion): void;

    public function resolve(FraudSuspicionInterface $fraudSuspicion): AddressInterface;
}