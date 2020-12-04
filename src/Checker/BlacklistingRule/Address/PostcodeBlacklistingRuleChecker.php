<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;

class PostcodeBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const POSTCODE_ATTRIBUTE_NAME = 'postcode';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $builder
            ->andWhere('o.postcode = :postcode')
            ->setParameter('postcode', $fraudSuspicionCommonModel->getPostcode())
        ;
    }

    public function getAttributeName(): string
    {
        return self::POSTCODE_ATTRIBUTE_NAME;
    }
}