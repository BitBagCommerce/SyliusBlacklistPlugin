<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\BlacklistingRule;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ChecksCodeImmutabilityTrait;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ChecksCodeImmutabilityTrait;

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

    public function isBlacklistingRuleDisabled(): bool
    {
        return $this->getDocument()->findField('Enabled')->isChecked();
    }
}
