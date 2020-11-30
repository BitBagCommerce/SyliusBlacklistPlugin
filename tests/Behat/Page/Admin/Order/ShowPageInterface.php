<?php

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\Order;

use Sylius\Behat\Page\Admin\Order\ShowPageInterface as BaseShowPageInterface;

interface ShowPageInterface extends BaseShowPageInterface
{
    public function clickButton(string $buttonName): void;
}