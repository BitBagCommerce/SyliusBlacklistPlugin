<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleEligibilityCheckerInterface;
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

    /** @var BlacklistingRuleEligibilityCheckerInterface */
    private $blacklistingRuleEligibilityChecker;

    public function __construct(
        ServiceRegistryInterface $serviceRegistry,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        ObjectManager $customerManager,
        BlacklistingRuleEligibilityCheckerInterface $blacklistingRuleEligibilityChecker,
    ) {
        $this->serviceRegistry = $serviceRegistry;
        $this->fraudSuspicionRepository = $fraudSuspicionRepository;
        $this->blacklistingRuleRepository = $blacklistingRuleRepository;
        $this->channelContext = $channelContext;
        $this->customerManager = $customerManager;
        $this->blacklistingRuleEligibilityChecker = $blacklistingRuleEligibilityChecker;
    }

    public function resolve(FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): bool
    {
        $blacklistingRules = $this->blacklistingRuleRepository->findActiveByChannel($this->getChannel());

        if (0 === \count($blacklistingRules)) {
            return false;
        }

        $customer = $fraudSuspicionCommonModel->getCustomer();

        /** @var BlacklistingRuleInterface $blacklistingRule */
        foreach ($blacklistingRules as $blacklistingRule) {
            if (!$this->blacklistingRuleEligibilityChecker->isEligible($blacklistingRule, $customer)) {
                continue;
            }

            $builder = $this->fraudSuspicionRepository->createQueryToLaunchBlacklistingRuleCheckers();

            foreach ($blacklistingRule->getAttributes() as $attribute) {
                $this->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel, $attribute);
            }

            if ((int) ($builder->getQuery()->getSingleScalarResult()) >= $blacklistingRule->getPermittedStrikes()) {
                return true;
            }
        }

        return false;
    }

    private function checkIfCustomerIsBlacklisted(
        QueryBuilder $builder,
        FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel,
        string $attribute,
    ): void {
        $checker = $this->serviceRegistry->get($attribute);

        $checker->checkIfCustomerIsBlacklisted($builder, $fraudSuspicionCommonModel);
    }

    private function getChannel(): ChannelInterface
    {
        return $this->channelContext->getChannel();
    }
}
