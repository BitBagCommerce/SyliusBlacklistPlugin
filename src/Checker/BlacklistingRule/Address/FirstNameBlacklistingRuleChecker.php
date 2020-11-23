<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Order\Model\OrderInterface;

class FirstNameBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const FIRST_NAME_ATTRIBUTE_NAME = 'first_name';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order): void
    {
        $builder
            ->andWhere('o.first_name = :firstName')
            ->setParameter('firstName', $order->getBillingAddress()->getFirstName())
        ;
    }

    public function getAttributeName(): string
    {
        return self::FIRST_NAME_ATTRIBUTE_NAME;
    }
}