<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;

class BlacklistingRule implements BlacklistingRuleInterface
{
    /** @var int|null */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $attributes;

    /** @var int */
    private $permittedStrikes;

    /** @var Collection|ChannelInterface[] */
    private $channels;

    /** @var bool */
    private $enabled;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getAttributes(): ?string
    {
        return $this->attributes;
    }

    public function setAttributes(string $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getPermittedStrikes(): ?int
    {
        return $this->permittedStrikes;
    }

    public function setPermittedStrikes(int $permittedStrikes)
    {
        $this->permittedStrikes = $permittedStrikes;
    }

    public function getChannels()
    {
        return $this->channels;
    }

    public function setChannels($channels)
    {
        $this->channels = $channels;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }
}
