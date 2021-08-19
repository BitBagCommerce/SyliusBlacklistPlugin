<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;

class CustomerIpBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const CUSTOMER_IP_ATTRIBUTE_NAME = 'customer_ip';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        if (!empty($fraudSuspicionCommonModel->getCustomerIp())) {
            $builder
                ->andWhere('o.customerIp = :customerIp')
                ->setParameter('customerIp', $fraudSuspicionCommonModel->getCustomerIp())
            ;
        }
    }

    public function getAttributeName(): string
    {
        return self::CUSTOMER_IP_ATTRIBUTE_NAME;
    }
}
