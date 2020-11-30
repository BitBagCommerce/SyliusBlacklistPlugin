<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class PostcodeBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const POSTCODE_ATTRIBUTE_NAME = 'postcode';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicion $newFraudSuspicion): void
    {
        $builder
            ->andWhere('o.postcode = :postcode')
            ->setParameter('postcode', $newFraudSuspicion->getPostcode())
        ;
    }

    public function getAttributeName(): string
    {
        return self::POSTCODE_ATTRIBUTE_NAME;
    }
}