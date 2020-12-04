<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

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
        $date = (new \DateTime())->modify('- ' . $blacklistingRule->getSettings()['date_modifier']);

        $numberOfPaymentFailures = $orderRepository
            ->findByCustomerPaymentFailuresAndPeriod($order->getCustomer(), $date)
        ;

        return $numberOfPaymentFailures >= $blacklistingRule->getSettings()['count'];
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}