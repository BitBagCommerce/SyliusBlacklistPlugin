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
    public function __construct(
        private ServiceRegistryInterface $serviceRegistry,
        private FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        private BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        private ChannelContextInterface $channelContext,
        private ObjectManager $customerManager,
        private BlacklistingRuleEligibilityCheckerInterface $blacklistingRuleEligibilityChecker,
    ) {
    }

    public function resolve(FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): bool
    {
        $blacklistingRules = $this->blacklistingRuleRepository->findActiveByChannel($this->getChannel());

        if ([] === $blacklistingRules) {
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
