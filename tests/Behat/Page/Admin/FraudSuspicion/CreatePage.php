<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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
}
