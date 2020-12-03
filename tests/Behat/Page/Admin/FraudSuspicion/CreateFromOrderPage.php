<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\FraudSuspicion;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsErrorTrait;

class CreateFromOrderPage extends BaseCreatePage implements CreateFromOrderPageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, ?string $value): self
    {
        if (empty($value)) {
            $value = '';
        }

        $this->getDocument()->fillField($field, $value);

        return $this;
    }

    public function selectOption(string $field, string $value): self
    {
        $this->getDocument()->selectFieldOption($field, $value);

        return $this;
    }
}
