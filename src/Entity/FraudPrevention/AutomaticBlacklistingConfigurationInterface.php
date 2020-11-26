<?php

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;

interface AutomaticBlacklistingConfigurationInterface extends ResourceInterface, TimestampableInterface, ToggleableInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(string $name): void;

    public function getRules(): Collection;

    public function hasRules(): bool;

    public function hasRule(AutomaticBlacklistingRuleInterface $rule): bool;

    public function addRule(AutomaticBlacklistingRuleInterface $rule): void;

    public function removeRule(AutomaticBlacklistingRuleInterface $rule): void;
}