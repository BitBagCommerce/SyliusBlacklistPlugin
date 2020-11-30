<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Customer;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class EmailBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const EMAIL_ATTRIBUTE_NAME = 'email';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicion $newFraudSuspicion): void
    {
        $builder
            ->andWhere('o.email = :email')
            ->setParameter('email', $newFraudSuspicion->getCustomer()->getEmail())
        ;
    }

    public function getAttributeName(): string
    {
        return self::EMAIL_ATTRIBUTE_NAME;
    }
}