<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Model;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;

trait FraudStatusTrait
{
    protected $fraudStatus = FraudStatusInterface::FRAUD_STATUS_NEUTRAL;

    public function getFraudStatus(): ?string
    {
        return $this->fraudStatus;
    }

    public function setFraudStatus(?string $fraudStatus): void
    {
        $this->fraudStatus = $fraudStatus;
    }
}