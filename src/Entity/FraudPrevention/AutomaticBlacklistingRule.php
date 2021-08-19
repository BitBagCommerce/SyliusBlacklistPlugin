<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

class AutomaticBlacklistingRule implements AutomaticBlacklistingRuleInterface
{
    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $type;

    /** @var array */
    protected $settings = [];

    /** @var AutomaticBlacklistingConfiguration|null */
    protected $configuration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function setSettings(array $settings): void
    {
        $this->settings = $settings;
    }

    public function getConfiguration(): ?AutomaticBlacklistingConfiguration
    {
        return $this->configuration;
    }

    public function setConfiguration(?AutomaticBlacklistingConfiguration $configuration): void
    {
        $this->configuration = $configuration;
    }
}
