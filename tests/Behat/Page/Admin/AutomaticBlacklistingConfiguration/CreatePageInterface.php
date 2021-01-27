<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\AutomaticBlacklistingConfiguration;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Sylius\Behat\Service\AutocompleteHelper;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    public function fillField(string $field, string $value): void;

    public function uncheckField(string $locator): void;

    public function selectOption(string $field, string $value): void;

    public function addRule(string $ruleName): void;

    public function selectRuleOption(string $option, string $value, bool $multiple = false): void;

    public function selectAutocompleteRuleOption(string $option, $value, bool $multiple = false): void;

    public function fillRuleOption(string $option, string $value): void;

    public function fillName(string $name): void;

    public function enable(): void;

    public function checkField(string $field): void;
}
