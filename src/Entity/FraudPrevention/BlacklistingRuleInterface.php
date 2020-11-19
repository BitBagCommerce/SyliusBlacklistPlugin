<?php

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface BlacklistingRuleInterface extends ResourceInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(string $name): void;

    public function getAttributes(): ?string;

    public function setAttributes(string $attributes);

    public function getPermittedStrikes(): ?int;

    public function setPermittedStrikes(int $permittedStrikes): void;

    public function getChannels();

    public function addChannel(ChannelInterface $channel): void;

    public function removeChannel(ChannelInterface $channel): void;

    public function hasChannel(ChannelInterface $channel): bool;
}