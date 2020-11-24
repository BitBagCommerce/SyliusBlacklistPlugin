<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Customer\Model\CustomerGroupInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;

class AutomaticBlacklistingRule implements AutomaticBlacklistingRuleInterface
{
    /** @var mixed */
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
