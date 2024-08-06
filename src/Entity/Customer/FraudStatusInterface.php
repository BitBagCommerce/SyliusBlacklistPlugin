<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\Customer;

interface FraudStatusInterface
{
    /** @var string */
    public const FRAUD_STATUS_NEUTRAL = 'neutral';

    /** @var string */
    public const FRAUD_STATUS_BLACKLISTED = 'blacklisted';

    /** @var string */
    public const FRAUD_STATUS_WHITELISTED = 'whitelisted';

    public function getFraudStatus(): ?string;

    public function setFraudStatus(?string $fraudStatus): void;
}
