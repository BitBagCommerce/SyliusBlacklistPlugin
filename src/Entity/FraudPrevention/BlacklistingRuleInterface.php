<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Customer\Model\CustomerGroupInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;

interface BlacklistingRuleInterface extends ResourceInterface, ToggleableInterface, TimestampableInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(string $name): void;

    public function getAttributes(): ?array;

    public function addAttribute(string $attribute): void;

    public function removeAttribute(string $attribute): void;

    public function getPermittedStrikes(): ?int;

    public function setPermittedStrikes(int $permittedStrikes): void;

    public function getChannels(): Collection;

    public function addChannel(ChannelInterface $channel): void;

    public function removeChannel(ChannelInterface $channel): void;

    public function hasChannel(ChannelInterface $channel): bool;

    public function getCustomerGroups(): Collection;

    public function addCustomerGroup(CustomerGroupInterface $customerGroup): void;

    public function removeCustomerGroup(CustomerGroupInterface $customerGroup): void;

    public function hasCustomerGroup(CustomerGroupInterface $customerGroup): bool;
}