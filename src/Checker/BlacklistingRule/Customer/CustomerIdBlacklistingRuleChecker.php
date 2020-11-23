<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Order\Model\OrderInterface;

class CustomerIdBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const CUSTOMER_ID_ATTRIBUTE_NAME = 'customer_id';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order): void
    {
        $builder
            ->andWhere('o.customerId = :customerId')
            ->setParameter('customerId', $order->getCustomer()->getId())
        ;
    }

    public function getAttributeName(): string
    {
        return self::CUSTOMER_ID_ATTRIBUTE_NAME;
    }
}