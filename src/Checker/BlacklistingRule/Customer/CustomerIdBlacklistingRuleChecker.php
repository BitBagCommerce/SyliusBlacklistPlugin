<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use Doctrine\ORM\QueryBuilder;

class CustomerIdBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const CUSTOMER_ID_ATTRIBUTE_NAME = 'customer_id';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModel $fraudSuspicionCommonModel): void
    {
        $builder
            ->andWhere('customer.id = :customerId')
            ->setParameter('customerId', $fraudSuspicionCommonModel->getCustomer()->getId())
        ;
    }

    public function getAttributeName(): string
    {
        return self::CUSTOMER_ID_ATTRIBUTE_NAME;
    }
}