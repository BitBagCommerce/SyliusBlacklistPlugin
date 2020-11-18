<?php

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Sylius\Component\Resource\Model\ResourceInterface;

interface BlacklistingRuleInterface extends ResourceInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(string $name);

    public function getAttributes(): ?string;

    public function setAttributes(string $attributes);

    public function getPermittedStrikes(): ?int;

    public function setPermittedStrikes(int $permittedStrikes);

    public function getChannels();

    public function setChannels($channels);

    public function getEnabled(): ?bool;

    public function setEnabled(bool $status);
}