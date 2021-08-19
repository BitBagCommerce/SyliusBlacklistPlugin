<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace spec\BitBag\SyliusBlacklistPlugin\Processor;

use BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule\OrdersAutomaticBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\FraudSuspicion\FraudSuspicionActionEligibilityCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionFactoryInterface;
use BitBag\SyliusBlacklistPlugin\Processor\AutomaticBlacklistingRulesProcessor;
use BitBag\SyliusBlacklistPlugin\Processor\AutomaticBlacklistingRulesProcessorInterface;
use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class AutomaticBlacklistingRulesProcessorSpec extends ObjectBehavior
{
    function let(
        ServiceRegistryInterface $serviceRegistry,
        OrderRepositoryInterface $orderRepository,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        CustomerStateResolverInterface $customerStateResolver,
        FraudSuspicionFactoryInterface $fraudSuspicionFactory,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        FraudSuspicionActionEligibilityCheckerInterface $fraudSuspicionActionEligibilityChecker
    ): void {
        $this->beConstructedWith(
            $serviceRegistry,
            $orderRepository,
            $automaticBlacklistingConfigurationRepository,
            $customerStateResolver,
            $fraudSuspicionFactory,
            $fraudSuspicionRepository,
            $fraudSuspicionActionEligibilityChecker
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
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        FraudSuspicionFactoryInterface $fraudSuspicionFactory,
        FraudSuspicionInterface $fraudSuspicion,
        FraudSuspicionActionEligibilityCheckerInterface $fraudSuspicionActionEligibilityChecker
    ): void {
        $automaticBlacklistingRules = new ArrayCollection([$automaticBlacklistingRule->getWrappedObject()]);

        $order->getChannel()->willReturn($channel);
        $automaticBlacklistingConfigurationRepository->findActiveByChannel($channel)->willReturn([$automaticBlacklistingConfiguration]);
        $automaticBlacklistingConfiguration->getRules()->willReturn($automaticBlacklistingRules);
        $automaticBlacklistingRule->getType()->willReturn('orders');
        $serviceRegistry->get('orders')->willReturn($ordersAutomaticBlacklistingRuleChecker);
        $ordersAutomaticBlacklistingRuleChecker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $orderRepository)->willReturn(true);
        $automaticBlacklistingConfiguration->isAddFraudSuspicion()->willReturn(true);
        $fraudSuspicionActionEligibilityChecker->canAddFraudSuspicion($order, $automaticBlacklistingConfiguration)->willReturn(true);
        $fraudSuspicionFactory->createForAutomaticBlacklistingConfiguration($order)->willReturn($fraudSuspicion);

        $order->getChannel()->shouldBeCalled();
        $automaticBlacklistingConfigurationRepository->findActiveByChannel($channel)->shouldBeCalled();
        $automaticBlacklistingConfiguration->getRules()->shouldBeCalled();
        $automaticBlacklistingRule->getType()->shouldBeCalled();
        $serviceRegistry->get('orders')->shouldBeCalled();
        $ordersAutomaticBlacklistingRuleChecker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $orderRepository)->shouldBeCalled();
        $automaticBlacklistingConfiguration->isAddFraudSuspicion()->shouldBeCalled();
        $fraudSuspicionActionEligibilityChecker->canAddFraudSuspicion($order, $automaticBlacklistingConfiguration)->shouldBeCalled();
        $fraudSuspicionFactory->createForAutomaticBlacklistingConfiguration($order)->shouldBeCalled();
        $fraudSuspicionRepository->add($fraudSuspicion)->shouldBeCalled();

        $this->process($order)->shouldReturn(true);
    }
}
