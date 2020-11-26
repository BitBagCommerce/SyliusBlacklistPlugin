<?php

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

    public function disable(): void
    {
        $this->getDocument()->uncheckField('Enabled');
    }

    public function associateSections(array $sectionsNames): void
    {
        Assert::isInstanceOf($this->getDriver(), Selenium2Driver::class);

        $dropdown = $this->getElement('association_dropdown_section');
        $dropdown->click();

        foreach ($sectionsNames as $sectionName) {
            $dropdown->waitFor(10, function () use ($sectionName) {
                return $this->hasElement('association_dropdown_section_item', [
                    '%item%' => $sectionName,
                ]);
            });

            $item = $this->getElement('association_dropdown_section_item', [
                '%item%' => $sectionName,
            ]);

            $item->click();
        }
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'association_dropdown_section' => '.field > label:contains("Sections") ~ .sylius-autocomplete',
            'association_dropdown_section_item' => '.field > label:contains("Sections") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
        ]);
    }
}
