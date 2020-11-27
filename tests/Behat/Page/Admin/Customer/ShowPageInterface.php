<?php

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\Customer;

use Sylius\Behat\Page\Admin\Customer\ShowPageInterface as BaseShowPageInterface;

interface ShowPageInterface extends BaseShowPageInterface
{
    public function clickButton(string $buttonName): void;
}