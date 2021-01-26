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
use Sylius\Component\Customer\Model\CustomerGroupInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;

class BlacklistingRule implements BlacklistingRuleInterface
{
    use ToggleableTrait;
    use TimestampableTrait;

    /** @var int|null */
    protected $id;

    /** @var string */
    protected $name;

    /** @var array */
    protected $attributes = [];

    /** @var int */
    protected $permittedStrikes;

    /** @var bool */
    protected $onlyForGuests = false;

    /**
     * @var Collection|ChannelInterface[]
     *
     * @psalm-var Collection<array-key, ChannelInterface>
     */
    protected $channels;

    /**
     * @var Collection|CustomerGroupInterface[]
     *
     * @psalm-var Collection<array-key, CustomerGroupInterface>
     */
    protected $customerGroups;

    /** @var bool */
    protected $forUnassignedCustomers = false;

    public function __construct()
    {
        $this->channels = new ArrayCollection();
        $this->customerGroups = new ArrayCollection();
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

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function addAttribute(string $attribute): void
    {
        $this->attributes[] = $attribute;
    }

    public function removeAttribute(string $attribute): void
    {
        $index = array_search($attribute, $this->attributes);

        if ($index !== false) {
            unset($this->attributes[$index]);
        }
    }

    public function getPermittedStrikes(): ?int
    {
        return $this->permittedStrikes;
    }

    public function setPermittedStrikes(?int $permittedStrikes): void
    {
        $this->permittedStrikes = $permittedStrikes;
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

    public function getCustomerGroups(): Collection
    {
        return $this->customerGroups;
    }

    public function addCustomerGroup(CustomerGroupInterface $customerGroup): void
    {
        if (!$this->hasCustomerGroup($customerGroup)) {
            $this->customerGroups->add($customerGroup);
        }
    }

    public function removeCustomerGroup(CustomerGroupInterface $customerGroup): void
    {
        if ($this->hasCustomerGroup($customerGroup)) {
            $this->customerGroups->removeElement($customerGroup);
        }
    }

    public function hasCustomerGroup(?CustomerGroupInterface $customerGroup): bool
    {
        if ($customerGroup === null) {
            return false;
        }

        return $this->customerGroups->contains($customerGroup);
    }

    public function isOnlyForGuests(): bool
    {
        return $this->onlyForGuests;
    }

    public function setOnlyForGuests(bool $onlyForGuests): void
    {
        $this->onlyForGuests = $onlyForGuests;
    }

    public function isForUnassignedCustomers(): bool
    {
        return $this->forUnassignedCustomers;
    }

    public function setForUnassignedCustomers(bool $forUnassignedCustomers): void
    {
        $this->forUnassignedCustomers = $forUnassignedCustomers;
    }
}
