<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face...start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Exception;

class WrongAddressTypeException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct(sprintf('Exception message: %s', $message));
    }
}