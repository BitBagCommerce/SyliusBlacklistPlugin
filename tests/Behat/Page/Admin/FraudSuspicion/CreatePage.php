<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);
namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\FraudSuspicion;

use Behat\Mink\Element\DocumentElement;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsErrorTrait;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, ?string $value): CreatePageInterface
    {
        if (empty($value)) {
            $value = '';
        }

        $this->getDocument()->fillField($field, $value);

        return $this;
    }

    public function selectOption(string $field, string $value): CreatePageInterface
    {
        $this->getDocument()->selectFieldOption($field, $value);

        return $this;
    }

    public function selectCustomer(string $customerEmail): CreatePageInterface
    {
        $dropdown = $this->getElement('customer_dropdown');
        $dropdown->click();

        $dropdown->waitFor(5, function () use ($customerEmail) {
            return $this->hasElement('customer_dropdown_item', [
                '%item%' => $customerEmail,
            ]);
        });

        $item = $this->getElement('customer_dropdown_item', [
            '%item%' => $customerEmail,
        ]);

        $item->click();

        return $this;
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'customer_dropdown' => '.field > label:contains("Customer") ~ .sylius-autocomplete',
            'customer_dropdown_item' => '.field > label:contains("Customer") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
        ]);
    }
}
