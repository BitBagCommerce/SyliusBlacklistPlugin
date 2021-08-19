<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

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

    public function setName(?string $name): void;

    public function getAttributes(): ?array;

    public function addAttribute(string $attribute): void;

    public function removeAttribute(string $attribute): void;

    public function getPermittedStrikes(): ?int;

    public function setPermittedStrikes(?int $permittedStrikes): void;

    public function getChannels(): Collection;

    public function addChannel(ChannelInterface $channel): void;

    public function removeChannel(ChannelInterface $channel): void;

    public function hasChannel(ChannelInterface $channel): bool;

    public function getCustomerGroups(): Collection;

    public function addCustomerGroup(CustomerGroupInterface $customerGroup): void;

    public function removeCustomerGroup(CustomerGroupInterface $customerGroup): void;

    public function hasCustomerGroup(?CustomerGroupInterface $customerGroup): bool;

    public function isOnlyForGuests(): bool;

    public function setOnlyForGuests(bool $onlyForGuests): void;

    public function isForUnassignedCustomers(): bool;

    public function setForUnassignedCustomers(bool $forUnassignedCustomers): void;
}
