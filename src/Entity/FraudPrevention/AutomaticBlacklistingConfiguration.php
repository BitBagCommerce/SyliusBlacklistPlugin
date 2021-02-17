<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;

class AutomaticBlacklistingConfiguration implements AutomaticBlacklistingConfigurationInterface
{
    use ToggleableTrait;
    use TimestampableTrait;

    /** @var int|null */
    protected $id;

    /** @var string */
    protected $name;

    /**
     * @var Collection|ChannelInterface[]
     *
     * @psalm-var Collection<array-key, ChannelInterface>
     */
    protected $channels;

    /**
     * @var Collection|AutomaticBlacklistingRuleInterface[]
     *
     * @psalm-var Collection<array-key, AutomaticBlacklistingRuleInterface>
     */
    protected $rules;

    /** @var bool */
    protected $addFraudSuspicion = false;

    /** @var int */
    protected $permittedFraudSuspicionsNumber;

    /** @var string */
    protected $permittedFraudSuspicionsTime;

    public function __construct()
    {
        $this->channels = new ArrayCollection();
        $this->rules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function hasRules(): bool
    {
        return !$this->rules->isEmpty();
    }

    public function hasRule(AutomaticBlacklistingRuleInterface $rule): bool
    {
        return $this->rules->contains($rule);
    }

    public function addRule(AutomaticBlacklistingRuleInterface $rule): void
    {
        if (!$this->hasRule($rule)) {
            $rule->setConfiguration($this);
            $this->rules->add($rule);
        }
    }

    public function removeRule(AutomaticBlacklistingRuleInterface $rule): void
    {
        if ($this->hasRule($rule)) {
            $rule->setConfiguration(null);
            $this->rules->removeElement($rule);
        }
    }

    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(ChannelInterface $channel): void
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);
        }
    }

    public function removeChannel(ChannelInterface $channel): void
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);
        }
    }

    public function hasChannel(ChannelInterface $channel): bool
    {
        return $this->channels->contains($channel);
    }

    public function isAddFraudSuspicion(): bool
    {
        return $this->addFraudSuspicion;
    }

    public function setAddFraudSuspicion(bool $addFraudSuspicion): void
    {
        $this->addFraudSuspicion = $addFraudSuspicion;
    }

    public function getPermittedFraudSuspicionsNumber(): ?int
    {
        return $this->permittedFraudSuspicionsNumber;
    }

    public function setPermittedFraudSuspicionsNumber(?int $permittedFraudSuspicionsNumber): void
    {
        $this->permittedFraudSuspicionsNumber = $permittedFraudSuspicionsNumber;
    }

    public function getPermittedFraudSuspicionsTime(): ?string
    {
        return $this->permittedFraudSuspicionsTime;
    }

    public function setPermittedFraudSuspicionsTime(?string $permittedFraudSuspicionsTime): void
    {
        $this->permittedFraudSuspicionsTime = $permittedFraudSuspicionsTime;
    }
}
