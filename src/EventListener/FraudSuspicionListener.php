<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\EventListener;

use BitBag\SyliusBlacklistPlugin\Converter\FraudSuspicionCommonModelConverterInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class FraudSuspicionListener
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

    public function processSuspicionOrder(GenericEvent $event): void
    {
        /** @var FraudSuspicionInterface $newFraudSuspicion */
        $newFraudSuspicion = $event->getSubject();

        $fraudSuspicionCommonModel = $this->fraudSuspicionCommonModelConverter->convertFraudSuspicionObject($newFraudSuspicion);

        if ($this->suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)) {
            $this->customerStateResolver->changeStateOnBlacklisted($newFraudSuspicion->getOrder()->getCustomer());
        }
    }
}