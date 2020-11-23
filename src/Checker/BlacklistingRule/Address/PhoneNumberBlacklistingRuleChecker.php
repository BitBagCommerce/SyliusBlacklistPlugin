<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Order\Model\OrderInterface;

class PhoneNumberBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const PHONE_NUMBER_ATTRIBUTE_NAME = 'phone_number';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order): void
    {
        $builder
            ->andWhere('o.phone_number = :phoneNumber')
            ->setParameter('phoneNumber', $order->getBillingAddress()->getPhoneNumber())
        ;
    }

    public function getAttributeName(): string
    {
        return self::PHONE_NUMBER_ATTRIBUTE_NAME;
    }
}