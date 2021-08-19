<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
        $date = (new \DateTime())->modify('- ' . $blacklistingRule->getSettings()['date_modifier']);

        $numberOfOrders = $orderRepository
            ->findPlacedOrdersByCustomerAndPeriod($order->getCustomer(), $date)
        ;

        return $numberOfOrders >= $blacklistingRule->getSettings()['count'];
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
