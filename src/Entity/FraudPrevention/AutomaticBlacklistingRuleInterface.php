<?php

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Sylius\Component\Resource\Model\ResourceInterface;

interface AutomaticBlacklistingRuleInterface extends ResourceInterface
{
    public function getId(): ?int;

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getSettings(): array;

    public function setSettings(array $settings): void;

    public function getConfiguration(): ?AutomaticBlacklistingConfiguration;

    public function setConfiguration(?AutomaticBlacklistingConfiguration $configuration): void;
}