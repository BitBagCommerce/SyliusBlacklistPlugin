<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);
namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\FraudSuspicion;

use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Session;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Sylius\Behat\Service\Helper\AutocompleteHelperInterface;
use Symfony\Component\Routing\RouterInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsErrorTrait;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function __construct(
        Session $session,
        $minkParameters,
        RouterInterface $router,
        string $routeName,
        private AutocompleteHelperInterface $autocompleteHelper,
    ) {
        parent::__construct($session, $minkParameters, $router, $routeName);
    }

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
        // For UX Autocomplete, we'll try to find the hidden input and set its value
        $customerField = $this->getElement('customer_dropdown');
        
        // Try to find the actual input field (might be hidden)
        $inputField = $this->getDocument()->find('css', 'input[name*="customer"]');
        if ($inputField) {
            $inputField->setValue($customerEmail);
        } else {
            // Fallback: try to fill the visible field
            $customerField->setValue($customerEmail);
        }

        return $this;
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'customer_dropdown' => '[data-test-fraud-suspicion-customer-autocomplete]',
        ]);
    }
}
