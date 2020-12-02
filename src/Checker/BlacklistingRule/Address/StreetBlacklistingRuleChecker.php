<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class StreetBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const STREET_ATTRIBUTE_NAME = 'street';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModel $fraudSuspicionCommonModel): void
    {
        $builder
            ->andWhere('o.street = :street')
            ->setParameter('street', $fraudSuspicionCommonModel->getStreet())
        ;
    }

    public function getAttributeName(): string
    {
        return self::STREET_ATTRIBUTE_NAME;
    }
}