<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class ProvinceBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const PROVINCE_ATTRIBUTE_NAME = 'province';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order, AddressInterface $address): void
    {
        $builder
            ->andWhere('o.province = :province')
            ->setParameter('province', $address->getProvinceName())
        ;
    }

    public function getAttributeName(): string
    {
        return self::PROVINCE_ATTRIBUTE_NAME;
    }
}