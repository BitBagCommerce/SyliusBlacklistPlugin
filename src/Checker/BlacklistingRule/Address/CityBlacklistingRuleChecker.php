<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;

class CityBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const CITY_ATTRIBUTE_NAME = 'city';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $builder
            ->andWhere('o.city = :city')
            ->setParameter('city', $fraudSuspicionCommonModel->getCity())
        ;
    }

    public function getAttributeName(): string
    {
        return self::CITY_ATTRIBUTE_NAME;
    }
}