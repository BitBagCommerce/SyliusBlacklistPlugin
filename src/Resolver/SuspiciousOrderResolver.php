<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
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

    public function resolve(FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): bool
    {
        $blacklistingRules = $this->blacklistingRuleRepository->findActiveByChannel($this->getChannel());

        if (\count($blacklistingRules) === 0) {
            return false;
        }

        $customerGroup = $fraudSuspicionCommonModel->getCustomer()->getGroup();

        /** @var BlacklistingRuleInterface $blacklistingRule */
        foreach ($blacklistingRules as $blacklistingRule) {
            if (
                !empty($customerGroup) &&
                !$blacklistingRule->getCustomerGroups()->isEmpty() &&
                !$blacklistingRule->hasCustomerGroup($customerGroup)
            ) {
                return false;
            }

            $builder = $this->fraudSuspicionRepository->createListQueryBuilder();

            foreach ($blacklistingRule->getAttributes() as $attribute) {
                $this->checkIfCustomerIsBlacklisted($builder,$fraudSuspicionCommonModel, $attribute);
            }

            if (\intval($builder->getQuery()->getSingleScalarResult()) + 1 >= $blacklistingRule->getPermittedStrikes()) {
                return true;
            }
        }

        return false;
    }

    private function checkIfCustomerIsBlacklisted(
        QueryBuilder $builder,
        FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel,
        string $attribute
    ): void {
        $checker = $this->serviceRegistry->get($attribute);

        $checker->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    private function getChannel(): ChannelInterface
    {
        return $this->channelContext->getChannel();
    }
}