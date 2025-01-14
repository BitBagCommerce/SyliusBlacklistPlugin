<?php

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
        private SuspiciousOrderResolverInterface $suspiciousOrderResolver,
        private CustomerStateResolverInterface $customerStateResolver,
        private FraudSuspicionCommonModelConverterInterface $fraudSuspicionCommonModelConverter
    ) {}

    public function prePersist(FraudSuspicionInterface $newFraudSuspicion, LifecycleEventArgs $event): void
    {
        $fraudSuspicionCommonModel = $this->fraudSuspicionCommonModelConverter->convertFraudSuspicionObject($newFraudSuspicion);

        if ($this->suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)) {
            $this->customerStateResolver->changeStateOnBlacklisted($newFraudSuspicion->getCustomer());
        }
    }
}
