<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class PhoneNumberBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const PHONE_NUMBER_ATTRIBUTE_NAME = 'phone_number';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicion $newFraudSuspicion): void
    {
        $builder
            ->andWhere('o.phoneNumber = :phoneNumber')
            ->setParameter('phoneNumber', $newFraudSuspicion->getPhoneNumber())
        ;
    }

    public function getAttributeName(): string
    {
        return self::PHONE_NUMBER_ATTRIBUTE_NAME;
    }
}