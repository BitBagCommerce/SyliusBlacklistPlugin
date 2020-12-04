<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\Order;

use Sylius\Behat\Page\Admin\Order\ShowPage as BaseShowPage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsEmptyListTrait;

class ShowPage extends BaseShowPage implements ShowPageInterface
{
    use ContainsEmptyListTrait;

    public function clickButton(string $buttonName): void
    {
        $this->getDocument()->clickLink($buttonName);
    }
}
