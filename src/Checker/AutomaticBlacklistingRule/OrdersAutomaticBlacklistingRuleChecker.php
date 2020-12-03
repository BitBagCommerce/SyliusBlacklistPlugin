<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\AutomaticBlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Model\OrderInterface;

class OrdersAutomaticBlacklistingRuleChecker implements AutomaticBlacklistingRuleCheckerInterface
{
    public const TYPE = 'orders';

    public function isBlacklistedOrderAndCustomer(
        AutomaticBlacklistingRuleInterface $blacklistingRule,
        OrderInterface $order,
        OrderRepositoryInterface $orderRepository
    ): bool {
        $numberOfOrders = $orderRepository
            ->findByCustomerOrdersInCurrentWeek($order->getCustomer(), $blacklistingRule->getSettings()['date_modifier'])
        ;

        return \intval($numberOfOrders) >= $blacklistingRule->getSettings()['count'];
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}