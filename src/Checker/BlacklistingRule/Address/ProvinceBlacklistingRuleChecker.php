<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;

class ProvinceBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const PROVINCE_ATTRIBUTE_NAME = 'province';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        if (!empty($fraudSuspicionCommonModel->getProvince())) {
            $builder
                ->andWhere('o.province = :province')
                ->setParameter('province', $fraudSuspicionCommonModel->getProvince())
            ;
        }
    }

    public function getAttributeName(): string
    {
        return self::PROVINCE_ATTRIBUTE_NAME;
    }
}