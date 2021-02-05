<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Processor;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleEligibilityCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionFactoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Sylius\Component\Core\Model\ChannelInterface;
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

    /** @var BlacklistingRuleEligibilityCheckerInterface */
    private $blacklistingRuleEligibilityChecker;

    /** @var BlacklistingRuleRepositoryInterface */
    private $blacklistingRuleRepository;

    public function __construct(
        ServiceRegistryInterface $serviceRegistry,
        OrderRepositoryInterface $orderRepository,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        CustomerStateResolverInterface $customerStateResolver,
        FraudSuspicionFactoryInterface $fraudSuspicionFactory,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        BlacklistingRuleEligibilityCheckerInterface $blacklistingRuleEligibilityChecker,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository
    ) {
        $this->serviceRegistry = $serviceRegistry;
        $this->orderRepository = $orderRepository;
        $this->automaticBlacklistingConfigurationRepository = $automaticBlacklistingConfigurationRepository;
        $this->customerStateResolver = $customerStateResolver;
        $this->fraudSuspicionFactory = $fraudSuspicionFactory;
        $this->fraudSuspicionRepository = $fraudSuspicionRepository;
        $this->blacklistingRuleEligibilityChecker = $blacklistingRuleEligibilityChecker;
        $this->blacklistingRuleRepository = $blacklistingRuleRepository;
    }

    public function process(OrderInterface $order): bool
    {
        $channel = $order->getChannel();

        $allAutomaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findActiveByChannel($channel);

        if (\count($allAutomaticBlacklistingConfiguration) === 0) {
            return false;
        }

        /** @var AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration */
        foreach ($allAutomaticBlacklistingConfiguration as $automaticBlacklistingConfiguration) {
            $automaticBlacklistingRules = $automaticBlacklistingConfiguration->getRules();

            /** @var AutomaticBlacklistingRuleInterface $automaticBlacklistingRule */
            foreach ($automaticBlacklistingRules as $automaticBlacklistingRule) {
                if ($this->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order)) {
                    if ($automaticBlacklistingConfiguration->isAddFraudSuspicion()) {
                        $this->addFraudSuspicion($order, $channel);
                    }

                    return true;
                }
            }
        }

        return false;
    }

    private function isBlacklistedOrderAndCustomer(AutomaticBlacklistingRuleInterface $automaticBlacklistingRule, OrderInterface $order): bool
    {
        $checker = $this->serviceRegistry->get($automaticBlacklistingRule->getType());

        return $checker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $this->orderRepository);
    }

    private function addFraudSuspicion(OrderInterface $order, ChannelInterface $channel): void
    {
        $blacklistingRules = $this->blacklistingRuleRepository->findActiveByChannel($channel);

        foreach ($blacklistingRules as $blacklistingRule) {
            if ($this->blacklistingRuleEligibilityChecker->isEligible($blacklistingRule, $order->getCustomer())) {
                $this->configureAndAddFraudSuspicion($order);

                return;
            }
        }
    }

    private function configureAndAddFraudSuspicion(OrderInterface $order): void
    {
        if (null === $this->fraudSuspicionRepository->findOneBy(['order' => $order])) {
            $fraudSuspicion = $this->fraudSuspicionFactory->createForOrder($order);
            $fraudSuspicion->setAddressType(FraudSuspicionInterface::SHIPPING_ADDRESS_TYPE);

            if (null === $fraudSuspicion->getCustomerIp()) {
                $fraudSuspicion->setCustomerIp($_SERVER['REMOTE_ADDR']);
            }

            $this->fraudSuspicionRepository->add($fraudSuspicion);
        }
    }
}