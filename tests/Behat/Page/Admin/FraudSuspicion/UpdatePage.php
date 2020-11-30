<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\FraudSuspicion;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ChecksCodeImmutabilityTrait;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ChecksCodeImmutabilityTrait;

    public function fillStreet(string $street): void
    {
        $this->getDocument()->fillField('Street', $street);
    }

    public function fillCity(string $city): void
    {
        $this->getDocument()->fillField('City', $city);
    }
}
