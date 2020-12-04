<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Sylius\Component\Resource\Model\ResourceInterface;

interface AutomaticBlacklistingRuleInterface extends ResourceInterface
{
    /** @var string */
    public const PER_DAY = '1 day';

    /** @var string */
    public const PER_WEEK = '1 week';

    /** @var string */
    public const PER_MONTH = '1 month';

    public function getId(): ?int;

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getSettings(): array;

    public function setSettings(array $settings): void;

    public function getConfiguration(): ?AutomaticBlacklistingConfiguration;

    public function setConfiguration(?AutomaticBlacklistingConfiguration $configuration): void;
}