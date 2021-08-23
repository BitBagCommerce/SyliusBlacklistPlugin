<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address\CityBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleEligibilityCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolver;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class SuspiciousOrderResolverSpec extends ObjectBehavior
{
    function let(
        ServiceRegistryInterface $serviceRegistry,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        ObjectManager $customerManager,
        BlacklistingRuleEligibilityCheckerInterface $blacklistingRuleEligibilityChecker
    ): void {
        $this->beConstructedWith(
            $serviceRegistry,
            $fraudSuspicionRepository,
            $blacklistingRuleRepository,
            $channelContext,
            $customerManager,
            $blacklistingRuleEligibilityChecker
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(SuspiciousOrderResolver::class);
    }

    function it_implements_interface(): void
    {
        $this->shouldHaveType(SuspiciousOrderResolverInterface::class);
    }

    function it_returns_false_if_store_does_not_have_any_active_rules(
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel,
        ChannelInterface $channel
    ): void {
        $channelContext->getChannel()->willReturn($channel);
        $blacklistingRuleRepository->findActiveByChannel($channel)->willReturn([]);

        $channelContext->getChannel()->shouldBeCalled();
        $blacklistingRuleRepository->findActiveByChannel($channel)->shouldBeCalled();

        $this->resolve($fraudSuspicionCommonModel)->shouldReturn(false);
    }

    function it_returns_false_if_blacklisting_rule_is_not_eligible(
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel,
        ChannelInterface $channel,
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer,
        BlacklistingRuleEligibilityCheckerInterface $blacklistingRuleEligibilityChecker
    ): void {
        $blacklistingRules = [$blacklistingRule];

        $channelContext->getChannel()->willReturn($channel);
        $blacklistingRuleRepository->findActiveByChannel($channel)->willReturn($blacklistingRules);
        $fraudSuspicionCommonModel->getCustomer()->willReturn($customer);
        $blacklistingRuleEligibilityChecker->isEligible($blacklistingRule, $customer)->willReturn(false);

        $channelContext->getChannel()->shouldBeCalled();
        $blacklistingRuleRepository->findActiveByChannel($channel)->shouldBeCalled();
        $fraudSuspicionCommonModel->getCustomer()->shouldBeCalled();
        $blacklistingRuleEligibilityChecker->isEligible($blacklistingRule, $customer)->shouldBeCalled();

        $this->resolve($fraudSuspicionCommonModel)->shouldReturn(false);
    }

    function it_returns_true_if_blacklisting_rule_should_block_customer(
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext,
        FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel,
        ChannelInterface $channel,
        BlacklistingRuleInterface $blacklistingRule,
        CustomerInterface $customer,
        BlacklistingRuleEligibilityCheckerInterface $blacklistingRuleEligibilityChecker,
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        QueryBuilder $builder,
        ServiceRegistryInterface $serviceRegistry,
        CityBlacklistingRuleChecker $cityBlacklistingRuleChecker,
        AbstractQuery $query
    ): void {
        $blacklistingRules = [$blacklistingRule];
        $blacklistingRuleAttributes = ['city'];

        $channelContext->getChannel()->willReturn($channel);
        $blacklistingRuleRepository->findActiveByChannel($channel)->willReturn($blacklistingRules);
        $fraudSuspicionCommonModel->getCustomer()->willReturn($customer);
        $blacklistingRuleEligibilityChecker->isEligible($blacklistingRule, $customer)->willReturn(true);
        $fraudSuspicionRepository->createQueryToLaunchBlacklistingRuleCheckers()->willReturn($builder);
        $blacklistingRule->getAttributes()->willReturn($blacklistingRuleAttributes);
        $serviceRegistry->get('city')->willReturn($cityBlacklistingRuleChecker);
        $builder->getQuery()->willReturn($query);
        $query->getSingleScalarResult()->willReturn(2);
        $blacklistingRule->getPermittedStrikes()->willReturn(2);

        $channelContext->getChannel()->shouldBeCalled();
        $blacklistingRuleRepository->findActiveByChannel($channel)->shouldBeCalled();
        $fraudSuspicionCommonModel->getCustomer()->shouldBeCalled();
        $blacklistingRuleEligibilityChecker->isEligible($blacklistingRule, $customer)->shouldBeCalled();
        $fraudSuspicionRepository->createQueryToLaunchBlacklistingRuleCheckers()->shouldBeCalled();
        $blacklistingRule->getAttributes()->shouldBeCalled();
        $serviceRegistry->get('city')->shouldBeCalled();
        $cityBlacklistingRuleChecker->checkIfCustomerIsBlacklisted($builder->getWrappedObject(), $fraudSuspicionCommonModel->getWrappedObject())->shouldBeCalled();
        $builder->getQuery()->shouldBeCalled();
        $query->getSingleScalarResult()->shouldBeCalled();
        $blacklistingRule->getPermittedStrikes()->shouldBeCalled();

        $this->resolve($fraudSuspicionCommonModel)->shouldReturn(true);
    }
}
