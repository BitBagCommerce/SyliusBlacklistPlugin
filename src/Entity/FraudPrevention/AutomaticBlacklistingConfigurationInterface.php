<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;

interface AutomaticBlacklistingConfigurationInterface extends ResourceInterface, TimestampableInterface, ToggleableInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getRules(): Collection;

    public function hasRules(): bool;

    public function hasRule(AutomaticBlacklistingRuleInterface $rule): bool;

    public function addRule(AutomaticBlacklistingRuleInterface $rule): void;

    public function removeRule(AutomaticBlacklistingRuleInterface $rule): void;

    public function getChannels(): Collection;

    public function addChannel(ChannelInterface $channel): void;

    public function removeChannel(ChannelInterface $channel): void;

    public function hasChannel(ChannelInterface $channel): bool;

    public function isAddFraudSuspicion(): bool;

    public function setAddFraudSuspicion(bool $addFraudSuspicion): void;

    public function getPermittedFraudSuspicionsNumber(): ?int;

    public function setPermittedFraudSuspicionsNumber(?int $permittedFraudSuspicionsNumber): void;

    public function getPermittedFraudSuspicionsTime(): ?string;

    public function setPermittedFraudSuspicionsTime(?string $permittedFraudSuspicionsTime): void;
}
