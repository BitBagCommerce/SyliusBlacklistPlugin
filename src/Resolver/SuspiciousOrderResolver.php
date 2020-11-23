<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

class SuspiciousOrderResolver implements SuspiciousOrderResolverInterface
{
    /** @var ServiceRegistryInterface */
    private $serviceRegistry;

    /** @var FraudSuspicionRepositoryInterface */
    private $fraudSuspicionRepository;

    /** @var BlacklistingRuleRepositoryInterface */
    private $blacklistingRuleRepository;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var ObjectManager */
    private $customerManager;

    public function __construct(
        ServiceRegistryInterface $serviceRegistry,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        ObjectManager $customerManager
    ) {
        $this->serviceRegistry = $serviceRegistry;
        $this->fraudSuspicionRepository = $fraudSuspicionRepository;
        $this->blacklistingRuleRepository = $blacklistingRuleRepository;
        $this->channelContext = $channelContext;
        $this->customerManager = $customerManager;
    }

    public function resolve(OrderInterface $order): bool
    {
        $checkers = $this->serviceRegistry->all();

        $blacklistingRules = $this->blacklistingRuleRepository->findByChannel($this->getChannel());

        if (\count($blacklistingRules) === 0) {
            return false;
        }

        /** @var BlacklistingRuleInterface $blacklistingRule */
        foreach ($blacklistingRules as $blacklistingRule) {
            $builder = $this->fraudSuspicionRepository->createListQueryBuilder();
            foreach ($checkers as $checker) {
                if (\in_array($checker->getAttributeName(), $blacklistingRule->getAttributes())) {
                    $checker->checkIfCustomerIsBlacklisted($builder, $order);
                }
            }

            if (\count($builder->getQuery()->getResult()) + 1 >= $blacklistingRule->getPermittedStrikes()) {
//                $customer = $order->getCustomer();
//                $customer->setFraudStatus(FraudStatusInterface::FRAUD_STATUS_BLACKLISTED);
//
//                $this->customerManager->persist($customer);
//                $this->customerManager->flush();
                return true;
            }
        }

        return false;
    }

    private function getChannel(): ChannelInterface
    {
        return $this->channelContext->getChannel();
    }
}