<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);
namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\AutomaticBlacklistingConfiguration;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Sylius\Behat\Service\AutocompleteHelper;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsErrorTrait;
use Webmozart\Assert\Assert;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function uncheckField(string $locator): void
    {
        $this->getDocument()->uncheckField($locator);
    }

    public function selectOption(string $field, string $value): void
    {
        $this->getDocument()->selectFieldOption($field, $value);
    }

    public function addRule(string $ruleName): void
    {
        $this->getElement($ruleName)->press();

        $form = $this->getElement('form');

        usleep(1000000); // we need to sleep, as sometimes the check below is executed faster than the form sets the busy attribute
        $form->waitFor(1500, fn () => !$form->hasAttribute('busy'));
    }

    public function selectRuleOption(string $option, string $value, bool $multiple = false): void
    {
        $this->getLastCollectionItem('rules')->find('named', ['select', $option])->selectOption($value, $multiple);
    }

    public function fillRuleOption(string $option, string $value): void
    {
        $this->getLastCollectionItem('rules')->fillField($option, $value);
    }

    public function fillRuleOption2(string $optionName, string $value): void
    {
        $field = $this->getDocument()->findField($optionName);
        if (null === $field) {
            throw new \InvalidArgumentException(sprintf('Field "%s" not found.', $optionName));
        }
        $field->setValue($value);
    }

    public function selectRuleOption2(string $optionName, string $value): void
    {
        $field = $this->getDocument()->findField($optionName);

        if (null === $field) {
            throw new \InvalidArgumentException(sprintf('Field "%s" not found.', $optionName));
        }
        $field->selectOption($value);
    }



    public function selectAutocompleteRuleOption(string $option, $value, bool $multiple = false): void
    {
        $option = strtolower(str_replace(' ', '_', $option));

        $ruleAutocomplete = $this
            ->getLastCollectionItem('rules')
            ->find('css', sprintf('input[type="hidden"][name*="[%s]"]', $option))
            ->getParent()
        ;

        if ($multiple && is_array($value)) {
            AutocompleteHelper::chooseValues($this->getSession(), $ruleAutocomplete, $value);

            return;
        }

        AutocompleteHelper::chooseValue($this->getSession(), $ruleAutocomplete, $value);
    }

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Configuration name', $name);
    }

    public function checkField(string $field): void
    {
        $this->getDocument()->checkField($field);
    }

    public function enable(): void
    {
        $this->getDocument()->checkField('Enabled');
    }

    protected function getDefinedElements(): array
    {
        return [
            'rules' => '#bitbag_sylius_blacklist_plugin_automatic_blacklisting_configuration_rules',
            'Max number of orders' => '[data-test-add-orders]',
            'Max number of payment failures' => '[data-test-add-payment_failures]',
            'form' => 'form',
        ];
    }

    private function getLastCollectionItem(string $collection): NodeElement
    {
        $items = $this->getCollectionItems($collection);

        // If no items exist, we need to add one first
        if (empty($items)) {
            // Try to find the add button for the collection
            $addButton = $this->getDocument()->find('css', '[data-test-add-' . strtolower(str_replace(' ', '_', $collection)) . ']');
            if ($addButton) {
                $addButton->click();
                // Wait a moment for the new item to be added
                $this->getDocument()->waitFor(2, function() use ($collection) {
                    return !empty($this->getCollectionItems($collection));
                });
                $items = $this->getCollectionItems($collection);
            }
        }

        // If still no items, try a different approach - look for the collection container itself
        if (empty($items)) {
            $collectionElement = $this->getElement($collection);
            // Return the collection element itself as a fallback
            return $collectionElement;
        }

        return end($items);
    }

    /**
     * @return NodeElement[]
     */
    private function getCollectionItems(string $collection): array
    {
        // Try different selectors for LiveCollectionType
        $selectors = [
            '[data-test-entry-row]',
            '[data-live-collection-entry]',
            '.collection-entry',
            '.form-group'
        ];
        
        foreach ($selectors as $selector) {
            $items = $this->getElement($collection)->findAll('css', $selector);
            if (!empty($items)) {
                Assert::isArray($items);
                return $items;
            }
        }
        
        // If no items found with any selector, return empty array
        return [];
    }
}
