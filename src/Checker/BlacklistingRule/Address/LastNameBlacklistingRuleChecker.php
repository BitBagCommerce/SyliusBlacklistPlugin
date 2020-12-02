<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use Doctrine\ORM\QueryBuilder;

class LastNameBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const LAST_NAME_ATTRIBUTE_NAME = 'last_name';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModel $fraudSuspicionCommonModel): void
    {
        $builder
            ->andWhere('o.lastName = :lastName')
            ->setParameter('lastName', $fraudSuspicionCommonModel->getLastName())
        ;
    }

    public function getAttributeName(): string
    {
        return self::LAST_NAME_ATTRIBUTE_NAME;
    }
}