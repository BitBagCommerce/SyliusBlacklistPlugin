<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

trait ContainsEmptyListTrait
{
    use DocumentAccessor;

    public function isEmpty(): bool
    {
        return false !== strpos($this->getDocument()->find('css', '.message')->getText(), 'There are no results to display');
    }
}
