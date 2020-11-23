<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Order\Model\OrderInterface;

class CountryBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const COUNTRY_ATTRIBUTE_NAME = 'country';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order): void
    {
        $builder
            ->andWhere('o.country = :country')
            ->setParameter('country', $order->getBillingAddress()->getCountryCode())
        ;
    }

    public function getAttributeName(): string
    {
        return self::COUNTRY_ATTRIBUTE_NAME;
    }
}