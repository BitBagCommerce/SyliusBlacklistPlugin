<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use Doctrine\ORM\QueryBuilder;

class CountryBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const COUNTRY_ATTRIBUTE_NAME = 'country';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModel $fraudSuspicionCommonModel): void
    {
        $builder
            ->andWhere('o.country = :country')
            ->setParameter('country', $fraudSuspicionCommonModel->getCountry())
        ;
    }

    public function getAttributeName(): string
    {
        return self::COUNTRY_ATTRIBUTE_NAME;
    }
}