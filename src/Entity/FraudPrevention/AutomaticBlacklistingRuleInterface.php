<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

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
