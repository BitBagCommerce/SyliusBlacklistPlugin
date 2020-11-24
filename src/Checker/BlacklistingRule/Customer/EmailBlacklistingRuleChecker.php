<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class EmailBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const EMAIL_ATTRIBUTE_NAME = 'email';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order, AddressInterface $address): void
    {
        $builder
            ->andWhere('o.email = :email')
            ->setParameter('email', $order->getCustomer()->getEmail())
        ;
    }

    public function getAttributeName(): string
    {
        return self::EMAIL_ATTRIBUTE_NAME;
    }
}