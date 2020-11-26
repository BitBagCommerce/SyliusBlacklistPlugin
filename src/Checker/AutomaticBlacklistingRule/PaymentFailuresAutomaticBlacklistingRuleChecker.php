<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Model\OrderInterface;

class PaymentFailuresAutomaticBlacklistingRuleChecker implements AutomaticBlacklistingRuleCheckerInterface
{
    public const TYPE = 'payment_failures';

    public function isBlacklistedOrderAndCustomer(
        AutomaticBlacklistingRuleInterface $blacklistingRule,
        OrderInterface $order,
        OrderRepositoryInterface $orderRepository
    ): bool {
        $numberOfPaymentFailures = $orderRepository
            ->findByCustomerPaymentFailuresInCurrentDay($order->getCustomer(), $blacklistingRule->getSettings()['date_modifier']);

        if (\intval($numberOfPaymentFailures) >= $blacklistingRule->getSettings()['count']) {
            return true;
        }

        return false;
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}