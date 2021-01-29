<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Processor;

use BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule\OrdersAutomaticBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleEligibilityCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionFactoryInterface;
use BitBag\SyliusBlacklistPlugin\Processor\AutomaticBlacklistingRulesProcessor;
use BitBag\SyliusBlacklistPlugin\Processor\AutomaticBlacklistingRulesProcessorInterface;
use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class AutomaticBlacklistingRulesProcessorSpec extends ObjectBehavior
{
    function let(
        ServiceRegistryInterface $serviceRegistry,
        OrderRepositoryInterface $orderRepository,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        CustomerStateResolverInterface $customerStateResolver,
        FraudSuspicionFactoryInterface $fraudSuspicionFactory,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        BlacklistingRuleEligibilityCheckerInterface $blacklistingRuleEligibilityChecker,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository
    ): void {
        $this->beConstructedWith(
            $serviceRegistry,
            $orderRepository,
            $automaticBlacklistingConfigurationRepository,
            $customerStateResolver,
            $fraudSuspicionFactory,
            $fraudSuspicionRepository,
            $blacklistingRuleEligibilityChecker,
            $blacklistingRuleRepository
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AutomaticBlacklistingRulesProcessor::class);
    }

    function it_implements_interface(): void
    {
        $this->shouldHaveType(AutomaticBlacklistingRulesProcessorInterface::class);
    }

    function it_returns_false(
        OrderInterface $order,
        ChannelInterface $channel,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository
    ): void {
        $order->getChannel()->willReturn($channel);
        $automaticBlacklistingConfigurationRepository->findActiveByChannel($channel)->willReturn([]);

        $order->getChannel()->shouldBeCalled();
        $automaticBlacklistingConfigurationRepository->findActiveByChannel($channel)->shouldBeCalled();

        $this->process($order)->shouldReturn(false);
    }

    function it_returns_true(
        OrderInterface $order,
        ChannelInterface $channel,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration,
        AutomaticBlacklistingRuleInterface $automaticBlacklistingRule,
        OrderRepositoryInterface $orderRepository,
        ServiceRegistryInterface $serviceRegistry,
        OrdersAutomaticBlacklistingRuleChecker $ordersAutomaticBlacklistingRuleChecker
    ): void {
        $automaticBlacklistingRules = new ArrayCollection([$automaticBlacklistingRule->getWrappedObject()]);

        $order->getChannel()->willReturn($channel);
        $automaticBlacklistingConfigurationRepository->findActiveByChannel($channel)->willReturn([$automaticBlacklistingConfiguration]);
        $automaticBlacklistingConfiguration->getRules()->willReturn($automaticBlacklistingRules);
        $automaticBlacklistingRule->getType()->willReturn('orders');
        $serviceRegistry->get('orders')->willReturn($ordersAutomaticBlacklistingRuleChecker);
        $ordersAutomaticBlacklistingRuleChecker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $orderRepository)->willReturn(true);
        $automaticBlacklistingConfiguration->isAddFraudSuspicion()->willReturn(false);

        $order->getChannel()->shouldBeCalled();
        $automaticBlacklistingConfigurationRepository->findActiveByChannel($channel)->shouldBeCalled();
        $automaticBlacklistingConfiguration->getRules()->shouldBeCalled();
        $automaticBlacklistingRule->getType()->shouldBeCalled();
        $serviceRegistry->get('orders')->shouldBeCalled();
        $ordersAutomaticBlacklistingRuleChecker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $orderRepository)->shouldBeCalled();

        $this->process($order)->shouldReturn(true);
    }

    function it_returns_true_and_add_fraud_suspicion(
        OrderInterface $order,
        ChannelInterface $channel,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration,
        AutomaticBlacklistingRuleInterface $automaticBlacklistingRule,
        OrderRepositoryInterface $orderRepository,
        ServiceRegistryInterface $serviceRegistry,
        OrdersAutomaticBlacklistingRuleChecker $ordersAutomaticBlacklistingRuleChecker,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        BlacklistingRuleInterface $blacklistingRule,
        BlacklistingRuleEligibilityCheckerInterface $blacklistingRuleEligibilityChecker,
        CustomerInterface $customer,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        FraudSuspicionFactoryInterface $fraudSuspicionFactory,
        FraudSuspicionInterface $fraudSuspicion
    ): void {
        $automaticBlacklistingRules = new ArrayCollection([$automaticBlacklistingRule->getWrappedObject()]);

        $order->getChannel()->willReturn($channel);
        $automaticBlacklistingConfigurationRepository->findActiveByChannel($channel)->willReturn([$automaticBlacklistingConfiguration]);
        $automaticBlacklistingConfiguration->getRules()->willReturn($automaticBlacklistingRules);
        $automaticBlacklistingRule->getType()->willReturn('orders');
        $serviceRegistry->get('orders')->willReturn($ordersAutomaticBlacklistingRuleChecker);
        $ordersAutomaticBlacklistingRuleChecker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $orderRepository)->willReturn(true);
        $automaticBlacklistingConfiguration->isAddFraudSuspicion()->willReturn(true);
        $blacklistingRuleRepository->findActiveByChannel($channel)->willReturn([$blacklistingRule]);
        $order->getCustomer()->willReturn($customer);
        $blacklistingRuleEligibilityChecker->isEligible($blacklistingRule, $customer)->willReturn(true);
        $fraudSuspicionRepository->findOneBy(['order' => $order])->willReturn(null);
        $fraudSuspicionFactory->createForOrder($order)->willReturn($fraudSuspicion);
        $fraudSuspicion->getCustomerIp()->willReturn(null);

        $order->getChannel()->shouldBeCalled();
        $automaticBlacklistingConfigurationRepository->findActiveByChannel($channel)->shouldBeCalled();
        $automaticBlacklistingConfiguration->getRules()->shouldBeCalled();
        $automaticBlacklistingRule->getType()->shouldBeCalled();
        $serviceRegistry->get('orders')->shouldBeCalled();
        $ordersAutomaticBlacklistingRuleChecker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $orderRepository)->shouldBeCalled();
        $blacklistingRuleRepository->findActiveByChannel($channel)->shouldBeCalled();
        $order->getCustomer()->shouldBeCalled();
        $blacklistingRuleEligibilityChecker->isEligible($blacklistingRule, $customer)->shouldBeCalled();
        $fraudSuspicionRepository->findOneBy(['order' => $order])->shouldBeCalled();
        $fraudSuspicionFactory->createForOrder($order)->shouldBeCalled();
        $fraudSuspicion->setAddressType(FraudSuspicionInterface::SHIPPING_ADDRESS_TYPE)->shouldBeCalled();
        $fraudSuspicion->getCustomerIp()->willReturn('127.0.0.1');
        $fraudSuspicionRepository->add($fraudSuspicion)->shouldBeCalled();

        $this->process($order)->shouldReturn(true);
    }
}
