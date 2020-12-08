<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Shop\Checkout;

use Sylius\Behat\Page\Shop\Checkout\AddressPage as BaseAddressPage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsErrorTrait;

class AddressPage extends BaseAddressPage implements AddressPageInterface
{
    use ContainsErrorTrait;
}
