<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
