<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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