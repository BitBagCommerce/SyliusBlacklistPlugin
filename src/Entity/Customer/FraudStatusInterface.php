<?php

namespace BitBag\SyliusBlacklistPlugin\Entity\Customer;

interface FraudStatusInterface
{
    /** @var string */
    public const FRAUD_STATUS_NEUTRAL = 'neutral';

    /** @var string */
    public const FRAUD_STATUS_BLACKLISTED = 'blacklisted';

    public function getFraudStatus(): ?string;

    public function setFraudStatus(?string $fraudStatus): void;
}
