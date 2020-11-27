<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\Customer;

use Sylius\Behat\Page\Admin\Customer\ShowPage as BaseShowPage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsEmptyListTrait;

class ShowPage extends BaseShowPage implements ShowPageInterface
{
    use ContainsEmptyListTrait;

    public function clickButton(string $buttonName): void
    {
        $this->getDocument()->findButton($buttonName)->click();
    }
}
