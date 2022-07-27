<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Processor;

use BitBag\SyliusBlacklistPlugin\Checker\FraudSuspicion\FraudSuspicionActionEligibilityCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionFactoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

class AutomaticBlacklistingRulesProcessor implements AutomaticBlacklistingRulesProcessorInterface
{
    /** @var ServiceRegistryInterface */
    private $serviceRegistry;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var CustomerStateResolverInterface */
    private $customerStateResolver;

    /** @var AutomaticBlacklistingConfigurationRepositoryInterface */
    private $automaticBlacklistingConfigurationRepository;

    /** @var FraudSuspicionFactoryInterface */
    private $fraudSuspicionFactory;

    /** @var FraudSuspicionRepositoryInterface */
    private $fraudSuspicionRepository;

    /** @var FraudSuspicionActionEligibilityCheckerInterface */
    private $fraudSuspicionActionEligibilityChecker;

    public function __construct(
        ServiceRegistryInterface $serviceRegistry,
        OrderRepositoryInterface $orderRepository,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        CustomerStateResolverInterface $customerStateResolver,
        FraudSuspicionFactoryInterface $fraudSuspicionFactory,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        FraudSuspicionActionEligibilityCheckerInterface $fraudSuspicionActionEligibilityChecker
    ) {
        $this->serviceRegistry = $serviceRegistry;
        $this->orderRepository = $orderRepository;
        $this->automaticBlacklistingConfigurationRepository = $automaticBlacklistingConfigurationRepository;
        $this->customerStateResolver = $customerStateResolver;
        $this->fraudSuspicionFactory = $fraudSuspicionFactory;
        $this->fraudSuspicionRepository = $fraudSuspicionRepository;
        $this->fraudSuspicionActionEligibilityChecker = $fraudSuspicionActionEligibilityChecker;
    }

    public function process(OrderInterface $order): bool
    {
        $channel = $order->getChannel();

        $allAutomaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findActiveByChannel($channel);

        if (0 === \count($allAutomaticBlacklistingConfiguration)) {
            return false;
        }

        /** @var AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration */
        foreach ($allAutomaticBlacklistingConfiguration as $automaticBlacklistingConfiguration) {
            if ($this->shouldOrderBeBlocked($automaticBlacklistingConfiguration, $order)) {
                return true;
            }
        }

        return false;
    }

    private function shouldOrderBeBlocked(
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration,
        OrderInterface $order
    ): bool {
        $automaticBlacklistingRules = $automaticBlacklistingConfiguration->getRules();

        /** @var AutomaticBlacklistingRuleInterface $automaticBlacklistingRule */
        foreach ($automaticBlacklistingRules as $automaticBlacklistingRule) {
            if ($this->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order)) {
                if (
                    $automaticBlacklistingConfiguration->isAddFraudSuspicion() &&
                    $this->fraudSuspicionActionEligibilityChecker->canAddFraudSuspicion($order, $automaticBlacklistingConfiguration)
                ) {
                    $fraudSuspicion = $this->fraudSuspicionFactory->createForAutomaticBlacklistingConfiguration($order);

                    $this->fraudSuspicionRepository->add($fraudSuspicion);
                }

                return true;
            }
        }

        return false;
    }

    private function isBlacklistedOrderAndCustomer(AutomaticBlacklistingRuleInterface $automaticBlacklistingRule, OrderInterface $order): bool
    {
        $checker = $this->serviceRegistry->get($automaticBlacklistingRule->getType());

        return $checker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $this->orderRepository);
    }
}
