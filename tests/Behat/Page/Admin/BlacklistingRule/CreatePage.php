<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);
namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\BlacklistingRule;

use Behat\Mink\Driver\Selenium2Driver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsErrorTrait;
use Webmozart\Assert\Assert;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function selectOption(string $field, string $value): void
    {
        $this->getDocument()->selectFieldOption($field, $value);
    }

    public function fillCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Rule name', $name);
    }

    public function fillLink(string $link): void
    {
        $this->getDocument()->fillField('Link', $link);
    }

    public function checkField(string $field): void
    {
        $this->getDocument()->checkField($field);
    }

    public function enable(): void
    {
        $this->getDocument()->checkField('Enabled');
    }
}
