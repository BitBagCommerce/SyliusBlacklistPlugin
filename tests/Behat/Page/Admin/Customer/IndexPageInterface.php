<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\Customer;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPageInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsEmptyListInterface;

interface IndexPageInterface extends BaseIndexPageInterface, ContainsEmptyListInterface
{
    public function getCustomerFraudStatus(string $email): string;
}
