<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Model;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\CustomerInterface;

trait CustomerTrait
{
    private $fraudStatus = CustomerInterface::FRAUD_STATUS_NEUTRAL;

    public function getFraudStatus(): string
    {
        return $this->fraudStatus;
    }

    public function setFraudStatus(string $fraudStatus)
    {
        $this->fraudStatus = $fraudStatus;
    }
}