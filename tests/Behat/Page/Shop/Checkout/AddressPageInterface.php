<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Shop\Checkout;

use Sylius\Behat\Page\Shop\Checkout\AddressPageInterface as BaseAddressPageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsErrorInterface;

interface AddressPageInterface extends BaseAddressPageInterface, ContainsErrorInterface
{

}
