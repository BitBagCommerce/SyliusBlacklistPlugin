<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\Address;

use BitBag\SyliusBlacklistPlugin\Checker\BlacklistingRule\BlacklistingRuleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Doctrine\ORM\QueryBuilder;

class PhoneNumberBlacklistingRuleChecker implements BlacklistingRuleCheckerInterface
{
    /** @var string */
    public const PHONE_NUMBER_ATTRIBUTE_NAME = 'phone_number';

    public function checkIfCustomerIsBlacklisted(QueryBuilder $builder, FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel): void
    {
        if (null !== $fraudSuspicionCommonModel->getPhoneNumber()) {
            $builder
                ->andWhere('o.phoneNumber = :phoneNumber')
                ->setParameter('phoneNumber', $fraudSuspicionCommonModel->getPhoneNumber())
            ;
        }
    }

    public function getAttributeName(): string
    {
        return self::PHONE_NUMBER_ATTRIBUTE_NAME;
    }
}