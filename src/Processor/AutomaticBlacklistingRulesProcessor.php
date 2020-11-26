<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Processor;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
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

    public function __construct(
        ServiceRegistryInterface $serviceRegistry,
        OrderRepositoryInterface $orderRepository,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        CustomerStateResolverInterface $customerStateResolver
    ) {
        $this->serviceRegistry = $serviceRegistry;
        $this->orderRepository = $orderRepository;
        $this->automaticBlacklistingConfigurationRepository = $automaticBlacklistingConfigurationRepository;
        $this->customerStateResolver = $customerStateResolver;
    }

    public function process(OrderInterface $order): bool
    {
        $checkers = $this->serviceRegistry->all();
        $customer = $order->getCustomer();

        $channel = $order->getChannel();

        $allAutomaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findByChannel($channel);

        if (\count($allAutomaticBlacklistingConfiguration) === 0) {
            return false;
        }

        /** @var AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration */
        foreach ($allAutomaticBlacklistingConfiguration as $automaticBlacklistingConfiguration ) {
            $automaticBlacklistingRules = $automaticBlacklistingConfiguration->getRules();
            /** @var AutomaticBlacklistingRuleInterface $automaticBlacklistingRule */
            foreach ($automaticBlacklistingRules as $automaticBlacklistingRule) {
                foreach ($checkers as $checker) {
                    if ($checker->getType() === $automaticBlacklistingRule->getType()) {
                        if (!($checker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $this->orderRepository))) {
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }
}