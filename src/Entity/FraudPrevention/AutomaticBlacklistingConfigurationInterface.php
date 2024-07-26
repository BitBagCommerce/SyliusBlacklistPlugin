<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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
