<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\EntityListener;

use BitBag\SyliusBlacklistPlugin\Converter\FraudSuspicionCommonModelConverterInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class FraudSuspicionEntityListener
{
    public function __construct(
        private readonly SuspiciousOrderResolverInterface $suspiciousOrderResolver,
        private readonly CustomerStateResolverInterface $customerStateResolver,
        private readonly FraudSuspicionCommonModelConverterInterface $fraudSuspicionCommonModelConverter,
    ) {
    }

    public function prePersist(FraudSuspicionInterface $newFraudSuspicion, LifecycleEventArgs $event): void
    {
        $fraudSuspicionCommonModel = $this->fraudSuspicionCommonModelConverter->convertFraudSuspicionObject($newFraudSuspicion);

        if ($this->suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)) {
            $this->customerStateResolver->changeStateOnBlacklisted($newFraudSuspicion->getCustomer());
        }
    }
}
