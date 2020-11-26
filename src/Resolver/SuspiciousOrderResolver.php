<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Model\AddressInterface;
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

    public function resolve(FraudSuspicionInterface $fraudSuspicion): bool
    {
        $checkers = $this->serviceRegistry->all();
        $order = $fraudSuspicion->getOrder();
        $address = $this->resolveAddressType($fraudSuspicion);

        $blacklistingRules = $this->blacklistingRuleRepository->findByChannel($this->getChannel());

        if (\count($blacklistingRules) === 0) {
            return false;
        }

        /** @var BlacklistingRuleInterface $blacklistingRule */
        foreach ($blacklistingRules as $blacklistingRule) {
            $builder = $this->fraudSuspicionRepository->createListQueryBuilder();
            foreach ($checkers as $checker) {
                if (\in_array($checker->getAttributeName(), $blacklistingRule->getAttributes())) {
                    $checker->checkIfCustomerIsBlacklisted($builder, $order, $address);
                }
            }

            if (\intval($builder->getQuery()->getSingleScalarResult()) + 1 >= $blacklistingRule->getPermittedStrikes()) {
                return true;
            }
        }

        return false;
    }

    private function resolveAddressType(FraudSuspicionInterface $fraudSuspicion): AddressInterface
    {
        $addressType = $fraudSuspicion->getAddressType();

        switch ($addressType) {
            case FraudSuspicion::BILLING_ADDRESS_TYPE:
                return $fraudSuspicion->getOrder()->getBillingAddress();
            case FraudSuspicion::SHIPPING_ADDRESS_TYPE:
                return $fraudSuspicion->getOrder()->getShippingAddress();
            default:
                throw new \Exception('Wrong address type!');
        }
    }

    private function getChannel(): ChannelInterface
    {
        return $this->channelContext->getChannel();
    }
}