<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule\AutomaticBlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule\PaymentFailuresAutomaticBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\OrderInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class PaymentFailuresAutomaticBlacklistingRuleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PaymentFailuresAutomaticBlacklistingRuleChecker::class);
    }

    function it_implements_automatic_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(AutomaticBlacklistingRuleCheckerInterface::class);
    }

    function it_returns_true_if_the_order_is_suspicious(
        AutomaticBlacklistingRuleInterface $blacklistingRule,
        OrderInterface $order,
        OrderRepositoryInterface $orderRepository,
        CustomerInterface $customer
    ): void {
        $order->getCustomer()->willReturn($customer);
        $blacklistingRule->getSettings()->willReturn(['count' => 1, 'date_modifier' => '1 day']);
        $orderRepository->findByCustomerPaymentFailuresAndPeriod($customer, Argument::type(\DateTime::class))->willReturn(1);

        $blacklistingRule->getSettings()->shouldBeCalled();
        $order->getCustomer()->shouldBeCalled();
        $orderRepository->findByCustomerPaymentFailuresAndPeriod($customer, Argument::type(\DateTime::class))->shouldBeCalled();

        $this->isBlacklistedOrderAndCustomer($blacklistingRule, $order, $orderRepository)->shouldReturn(true);
    }

    function it_returns_false_if_the_order_is_no_suspicious(
        AutomaticBlacklistingRuleInterface $blacklistingRule,
        OrderInterface $order,
        OrderRepositoryInterface $orderRepository,
        CustomerInterface $customer
    ): void {
        $order->getCustomer()->willReturn($customer);
        $blacklistingRule->getSettings()->willReturn(['count' => 3, 'date_modifier' => '1 day']);
        $orderRepository->findByCustomerPaymentFailuresAndPeriod($customer, Argument::type(\DateTime::class))->willReturn(1);

        $blacklistingRule->getSettings()->shouldBeCalled();
        $order->getCustomer()->shouldBeCalled();
        $orderRepository->findByCustomerPaymentFailuresAndPeriod($customer, Argument::type(\DateTime::class))->shouldBeCalled();

        $this->isBlacklistedOrderAndCustomer($blacklistingRule, $order, $orderRepository)->shouldReturn(false);
    }

    function it_gets_type(): void
    {
        $this->getType()->shouldReturn(PaymentFailuresAutomaticBlacklistingRuleChecker::TYPE);
    }
}
