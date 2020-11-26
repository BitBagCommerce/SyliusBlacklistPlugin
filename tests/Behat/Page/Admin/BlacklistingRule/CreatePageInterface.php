<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\BlacklistingRule;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    public function fillField(string $field, string $value): void;

    public function selectOption(string $field, string $value): void;

    public function fillCode(string $code): void;

    public function fillName(string $name): void;

    public function fillLink(string $link): void;

    public function associateSections(array $sectionsNames): void;

    public function disable(): void;
}
