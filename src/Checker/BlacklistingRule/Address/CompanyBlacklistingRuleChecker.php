<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;

class CompanyBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const COMPANY_ATTRIBUTE_NAME = 'company';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        if (null !== $fraudSuspicionCommonModel->getCompany()) {
            $builder
                ->andWhere('o.company = :company')
                ->setParameter('company', $fraudSuspicionCommonModel->getCompany())
            ;
        }
    }

    public function getAttributeName(): string
    {
        return self::COMPANY_ATTRIBUTE_NAME;
    }
}