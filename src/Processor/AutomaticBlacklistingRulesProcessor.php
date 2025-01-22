<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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
    public function __construct(
        private readonly ServiceRegistryInterface                     $serviceRegistry,
        private OrderRepositoryInterface                              $orderRepository,
        private AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        private CustomerStateResolverInterface                        $customerStateResolver,
        private FraudSuspicionFactoryInterface                        $fraudSuspicionFactory,
        private FraudSuspicionRepositoryInterface                     $fraudSuspicionRepository,
        private FraudSuspicionActionEligibilityCheckerInterface       $fraudSuspicionActionEligibilityChecker
    ) {}

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
        OrderInterface $order,
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
