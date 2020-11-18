<?php

namespace BitBag\SyliusBlacklistPlugin\Entity\Customer;

use Sylius\Component\Core\Model\CustomerInterface as BaseCustomerInterface;

interface CustomerInterface extends BaseCustomerInterface
{
    /** @var string */
    public const FRAUD_STATUS_NEUTRAL = 'neutral';

    /** @var string */
    public const FRAUD_STATUS_BLACKLISTED = 'blacklisted';

    public function getFraudStatus(): string;

    public function setFraudStatus(string $fraudStatus);
}
