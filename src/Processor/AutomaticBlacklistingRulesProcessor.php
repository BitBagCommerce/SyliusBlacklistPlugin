<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Processor;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class AutomaticBlacklistingRulesProcessor implements AutomaticBlacklistingRulesProcessorInterface
{
    /** @var ServiceRegistryInterface */
    private $serviceRegistry;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var RepositoryInterface */
    private $automaticBlacklistingConfigurationRepository;

    /** @var CustomerStateResolverInterface */
    private $customerStateResolver;

    public function __construct(
        ServiceRegistryInterface $serviceRegistry,
        OrderRepositoryInterface $orderRepository,
        RepositoryInterface $automaticBlacklistingConfigurationRepository,
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

        $allAutomaticBlacklistingConfiguration = $this->automaticBlacklistingConfigurationRepository->findAll();

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
                        if ($checker->isBlacklistedOrderAndCustomer($automaticBlacklistingRule, $order, $this->orderRepository)) {
                            $this->customerStateResolver->changeStateOnBlacklisted($customer);
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}