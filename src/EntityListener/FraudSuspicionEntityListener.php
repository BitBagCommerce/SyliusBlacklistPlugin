<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\EntityListener;

use BitBag\SyliusBlacklistPlugin\Converter\FraudSuspicionCommonModelConverterInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

final class FraudSuspicionEntityListener
{
    /** @var SuspiciousOrderResolverInterface */
    private $suspiciousOrderResolver;

    /** @var CustomerStateResolverInterface */
    private $customerStateResolver;

    /** @var FraudSuspicionCommonModelConverterInterface */
    private $fraudSuspicionCommonModelConverter;

    public function __construct(
        SuspiciousOrderResolverInterface $suspiciousOrderResolver,
        CustomerStateResolverInterface $customerStateResolver,
        FraudSuspicionCommonModelConverterInterface $fraudSuspicionCommonModelConverter
    ) {
        $this->suspiciousOrderResolver = $suspiciousOrderResolver;
        $this->customerStateResolver = $customerStateResolver;
        $this->fraudSuspicionCommonModelConverter = $fraudSuspicionCommonModelConverter;
    }

    public function prePersist(FraudSuspicionInterface $newFraudSuspicion, LifecycleEventArgs $event)
    {
        $fraudSuspicionCommonModel = $this->fraudSuspicionCommonModelConverter->convertFraudSuspicionObject($newFraudSuspicion);

        if ($this->suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)) {
            $this->customerStateResolver->changeStateOnBlacklisted($newFraudSuspicion->getCustomer());
        }
    }

}
