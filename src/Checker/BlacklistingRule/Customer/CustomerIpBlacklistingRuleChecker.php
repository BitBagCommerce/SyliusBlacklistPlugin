<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Order\Model\OrderInterface;

class CustomerIpBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const CUSTOMER_IP_ATTRIBUTE_NAME = 'customer_ip';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order): void
    {
        $builder
            ->andWhere('o.customer_ip = :customerIp')
            ->setParameter('customerIp', $order->getCustomerIp())
        ;
    }

    public function getAttributeName(): string
    {
        return self::CUSTOMER_IP_ATTRIBUTE_NAME;
    }
}