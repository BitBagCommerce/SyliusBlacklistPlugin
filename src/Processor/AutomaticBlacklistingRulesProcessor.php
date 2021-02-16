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
use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionFactoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
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

    public function __construct(
        ServiceRegistryInterface $serviceRegistry,
        OrderRepositoryInterface $orderRepository,
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        CustomerStateResolverInterface $customerStateResolver,
        FraudSuspicionFactoryInterface $fraudSuspicionFactory,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository
    ) {
        $this->serviceRegistry = $serviceRegistry;
        $this->orderRepository = $orderRepository;
        $this->automaticBlacklistingConfigurationRepository = $automaticBlacklistingConfigurationRepository;
        $this->customerStateResolver = $customerStateResolver;
        $this->fraudSuspicionFactory = $fraudSuspicionFactory;
        $this->fraudSuspicionRepository = $fraudSuspicionRepository;
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
                    if (
                        $automaticBlacklistingConfiguration->isAddFraudSuspicion() &&
                        $this->canAddFraudSuspicion($order, $automaticBlacklistingConfiguration)
                    ) {
                        $fraudSuspicion = $this->fraudSuspicionFactory->createForAutomaticBlacklistingConfiguration($order);

                        $this->fraudSuspicionRepository->add($fraudSuspicion);
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

    private function canAddFraudSuspicion(
        OrderInterface $order,
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration
    ): bool {
        if (null === $this->fraudSuspicionRepository->findOneBy(['order' => $order])) {
            return false;
        }

        $date = (new \DateTime())->modify('- ' . $automaticBlacklistingConfiguration->getPermittedFraudSuspicionTime());

        $customer = $order->getCustomer();

        $lastFraudSuspicionsOfCustomer = $this->fraudSuspicionRepository->countByCustomerAndCommentAndDate(
            $order->getCustomer(),
            FraudSuspicionInterface::AUTOMATIC_BLACKLISTING_CONFIGURATION_COMMENT,
            $date
        );

        if ($lastFraudSuspicionsOfCustomer >= $automaticBlacklistingConfiguration->getPermittedFraudSuspicionCount()) {
            $customer->setFraudStatus(FraudStatusInterface::FRAUD_STATUS_BLACKLISTED);

            return false;
        }

        return true;
    }
}