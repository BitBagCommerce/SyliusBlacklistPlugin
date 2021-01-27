<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\EntityListener;

use BitBag\SyliusBlacklistPlugin\Converter\FraudSuspicionCommonModelConverterInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\EntityListener\FraudSuspicionEntityListener;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use PhpSpec\ObjectBehavior;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class FraudSuspicionEntityListenerSpec extends ObjectBehavior
{
    function let(
        SuspiciousOrderResolverInterface $suspiciousOrderResolver,
        CustomerStateResolverInterface $customerStateResolver,
        FraudSuspicionCommonModelConverterInterface $fraudSuspicionCommonModelConverter
    ) {
        $this->beConstructedWith($suspiciousOrderResolver, $customerStateResolver, $fraudSuspicionCommonModelConverter);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(FraudSuspicionEntityListener::class);
    }

    function it_changes_customer_fraud_status_on_blacklisted(
        SuspiciousOrderResolverInterface $suspiciousOrderResolver,
        CustomerStateResolverInterface $customerStateResolver,
        FraudSuspicionCommonModelConverterInterface $fraudSuspicionCommonModelConverter,
        FraudSuspicionInterface $newFraudSuspicion,
        LifecycleEventArgs $event,
        FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel,
        CustomerInterface $customer
    ): void {
        $fraudSuspicionCommonModelConverter->convertFraudSuspicionObject($newFraudSuspicion)->willReturn($fraudSuspicionCommonModel);
        $suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)->willReturn(true);
        $newFraudSuspicion->getCustomer()->willReturn($customer);

        $fraudSuspicionCommonModelConverter->convertFraudSuspicionObject($newFraudSuspicion)->shouldBeCalled();
        $suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)->shouldBeCalled();
        $newFraudSuspicion->getCustomer()->shouldBeCalled();
        $customerStateResolver->changeStateOnBlacklisted($customer)->shouldBeCalled();

        $this->prePersist($newFraudSuspicion, $event);
    }

    function it_does_not_change_customer_fraud_status_on_blacklisted(
        SuspiciousOrderResolverInterface $suspiciousOrderResolver,
        FraudSuspicionCommonModelConverterInterface $fraudSuspicionCommonModelConverter,
        FraudSuspicionInterface $newFraudSuspicion,
        LifecycleEventArgs $event,
        FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel
    ): void {
        $fraudSuspicionCommonModelConverter->convertFraudSuspicionObject($newFraudSuspicion)->willReturn($fraudSuspicionCommonModel);
        $suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)->willReturn(false);

        $fraudSuspicionCommonModelConverter->convertFraudSuspicionObject($newFraudSuspicion)->shouldBeCalled();
        $suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)->shouldBeCalled();

        $this->prePersist($newFraudSuspicion, $event);
    }
}
