<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

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
                ->andWhere('o.customer_ip = :customerIp')
                ->setParameter('customerIp', $fraudSuspicionCommonModel->getCustomerIp())
            ;
        }
    }

    public function getAttributeName(): string
    {
        return self::CUSTOMER_IP_ATTRIBUTE_NAME;
    }
}