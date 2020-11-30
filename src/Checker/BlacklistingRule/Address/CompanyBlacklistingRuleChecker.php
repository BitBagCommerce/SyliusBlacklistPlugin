<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class CompanyBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const COMPANY_ATTRIBUTE_NAME = 'company';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicion $newFraudSuspicion): void
    {
        $builder
            ->andWhere('o.company = :company')
            ->setParameter('company', $newFraudSuspicion->getCompany())
        ;
    }

    public function getAttributeName(): string
    {
        return self::COMPANY_ATTRIBUTE_NAME;
    }
}