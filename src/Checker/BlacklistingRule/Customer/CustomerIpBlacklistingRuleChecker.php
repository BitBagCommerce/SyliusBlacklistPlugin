<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use Doctrine\ORM\QueryBuilder;

class CustomerIpBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const CUSTOMER_IP_ATTRIBUTE_NAME = 'customer_ip';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModel $fraudSuspicionCommonModel): void
    {
        $builder
            ->andWhere('o.customer_ip = :customerIp')
            ->setParameter('customerIp', $fraudSuspicionCommonModel->getCustomerIp())
        ;
    }

    public function getAttributeName(): string
    {
        return self::CUSTOMER_IP_ATTRIBUTE_NAME;
    }
}