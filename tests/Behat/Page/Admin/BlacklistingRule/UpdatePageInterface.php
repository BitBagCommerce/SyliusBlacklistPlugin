<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\BlacklistingRule;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ChecksCodeImmutabilityInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface, ChecksCodeImmutabilityInterface
{
    public function fillName(string $name): void;

    public function fillLink(string $link): void;

    public function disable(): void;

    public function isBlockDisabled(): bool;
}
