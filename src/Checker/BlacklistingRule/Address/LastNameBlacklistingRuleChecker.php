<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class LastNameBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const LAST_NAME_ATTRIBUTE_NAME = 'last_name';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicion $newFraudSuspicion): void
    {
        $builder
            ->andWhere('o.lastName = :lastName')
            ->setParameter('lastName', $newFraudSuspicion->getLastName())
        ;
    }

    public function getAttributeName(): string
    {
        return self::LAST_NAME_ATTRIBUTE_NAME;
    }
}