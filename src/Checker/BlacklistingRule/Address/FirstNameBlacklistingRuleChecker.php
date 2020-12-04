<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;

class FirstNameBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const FIRST_NAME_ATTRIBUTE_NAME = 'first_name';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $builder
            ->andWhere('o.firstName = :firstName')
            ->setParameter('firstName', $fraudSuspicionCommonModel->getFirstName())
        ;
    }

    public function getAttributeName(): string
    {
        return self::FIRST_NAME_ATTRIBUTE_NAME;
    }
}