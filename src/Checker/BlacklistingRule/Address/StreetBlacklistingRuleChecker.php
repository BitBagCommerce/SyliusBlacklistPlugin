<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;

class StreetBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const STREET_ATTRIBUTE_NAME = 'street';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        $builder
            ->andWhere('o.street = :street')
            ->setParameter('street', $fraudSuspicionCommonModel->getStreet())
        ;
    }

    public function getAttributeName(): string
    {
        return self::STREET_ATTRIBUTE_NAME;
    }
}
