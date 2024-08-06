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

class CustomerIdBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const CUSTOMER_ID_ATTRIBUTE_NAME = 'customer_id';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
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
