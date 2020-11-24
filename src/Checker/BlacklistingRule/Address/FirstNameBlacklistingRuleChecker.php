<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class FirstNameBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const FIRST_NAME_ATTRIBUTE_NAME = 'first_name';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order, AddressInterface $address): void
    {
        $builder
            ->andWhere('o.firstName = :firstName')
            ->setParameter('firstName', $address->getFirstName())
        ;
    }

    public function getAttributeName(): string
    {
        return self::FIRST_NAME_ATTRIBUTE_NAME;
    }
}