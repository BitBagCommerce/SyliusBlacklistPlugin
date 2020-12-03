<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule\AutomaticBlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule\PaymentFailuresAutomaticBlacklistingRuleChecker;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use PhpSpec\ObjectBehavior;
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
    ): void
    {
        $blacklistingRule->getSettings()->willReturn(['count' => 1, 'date_modifier' => '1 day']);

        $order->getCustomer()->willReturn($customer);

        $orderRepository->findByCustomerOrdersInCurrentWeek($customer, '1 day')->willReturn("1");

        $this->isBlacklistedOrderAndCustomer($blacklistingRule, $order, $orderRepository)->shouldReturn(true);
    }

    function it_gets_type(): void {
        $this->getType()->shouldReturn(PaymentFailuresAutomaticBlacklistingRuleChecker::TYPE);
    }
}
