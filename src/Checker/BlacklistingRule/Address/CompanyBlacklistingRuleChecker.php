<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Order\Model\OrderInterface;

class CompanyBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const COMPANY_ATTRIBUTE_NAME = 'company';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, OrderInterface $order): void
    {
        $builder
            ->andWhere('o.company = :company')
            ->setParameter('company', $order->getBillingAddress()->getCompany())
        ;
    }

    public function getAttributeName(): string
    {
        return self::COMPANY_ATTRIBUTE_NAME;
    }
}