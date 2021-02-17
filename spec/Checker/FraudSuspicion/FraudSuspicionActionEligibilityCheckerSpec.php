<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\FraudSuspicion;

use BitBag\SyliusBlacklistPlugin\Checker\FraudSuspicion\FraudSuspicionActionEligibilityChecker;
use BitBag\SyliusBlacklistPlugin\Checker\FraudSuspicion\FraudSuspicionActionEligibilityCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

final class FraudSuspicionActionEligibilityCheckerSpec extends ObjectBehavior
{
    function let(
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        CustomerStateResolverInterface $customerStateResolver
    ): void {
        $this->beConstructedWith($fraudSuspicionRepository, $customerStateResolver);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(FraudSuspicionActionEligibilityChecker::class);
    }

    function it_implements_automatic_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(FraudSuspicionActionEligibilityCheckerInterface::class);
    }

    function it_returns_false_if_the_order_for_fraud_suspicion_already_exist(
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration,
        OrderInterface $order,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        FraudSuspicionInterface $fraudSuspicion
    ): void {
        $fraudSuspicionRepository->findOneBy(['order' => $order])->willReturn($fraudSuspicion);

        $fraudSuspicionRepository->findOneBy(['order' => $order])->shouldBeCalled();

        $this->canAddFraudSuspicion($order, $automaticBlacklistingConfiguration)->shouldReturn(false);
    }

    function it_returns_false_if_the_customer_exceeds_permitted_fraud_suspicions_number(
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration,
        OrderInterface $order,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        CustomerInterface $customer,
        CustomerStateResolverInterface $customerStateResolver
    ): void {
        $fraudSuspicionRepository->findOneBy(['order' => $order])->willReturn(null);
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime()->willReturn('1 day');
        $order->getCustomer()->willReturn($customer);
        $fraudSuspicionRepository->countByCustomerAndCommentAndDate(
            $customer,
            FraudSuspicionInterface::AUTO_GENERATED_STATUS,
            Argument::type(\DateTime::class)
        )->willReturn('2');
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()->willReturn(2);

        $fraudSuspicionRepository->findOneBy(['order' => $order])->shouldBeCalled();
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime()->shouldBeCalled();
        $order->getCustomer()->shouldBeCalled();
        $fraudSuspicionRepository->countByCustomerAndCommentAndDate(
            $customer,
            FraudSuspicionInterface::AUTO_GENERATED_STATUS,
            Argument::type(\DateTime::class)
        )->shouldBeCalled();
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()->shouldBeCalled();
        $customerStateResolver->changeStateOnBlacklisted($customer)->shouldBeCalled();

        $this->canAddFraudSuspicion($order, $automaticBlacklistingConfiguration)->shouldReturn(false);
    }

    function it_returns_true(
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration,
        OrderInterface $order,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        CustomerInterface $customer,
        CustomerStateResolverInterface $customerStateResolver
    ): void {
        $fraudSuspicionRepository->findOneBy(['order' => $order])->willReturn(null);
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime()->willReturn('1 day');
        $order->getCustomer()->willReturn($customer);
        $fraudSuspicionRepository->countByCustomerAndCommentAndDate(
            $customer,
            FraudSuspicionInterface::AUTO_GENERATED_STATUS,
            Argument::type(\DateTime::class)
        )->willReturn('2');
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()->willReturn(3);

        $fraudSuspicionRepository->findOneBy(['order' => $order])->shouldBeCalled();
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime()->shouldBeCalled();
        $order->getCustomer()->shouldBeCalled();
        $fraudSuspicionRepository->countByCustomerAndCommentAndDate(
            $customer,
            FraudSuspicionInterface::AUTO_GENERATED_STATUS,
            Argument::type(\DateTime::class)
        )->shouldBeCalled();
        $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()->shouldBeCalled();

        $this->canAddFraudSuspicion($order, $automaticBlacklistingConfiguration)->shouldReturn(true);
    }
}
