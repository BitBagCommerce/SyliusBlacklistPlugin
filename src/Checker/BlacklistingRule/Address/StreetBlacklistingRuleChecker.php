<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use Doctrine\ORM\QueryBuilder;

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