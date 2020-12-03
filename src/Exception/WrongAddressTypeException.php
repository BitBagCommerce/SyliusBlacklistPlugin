<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Exception;

class WrongAddressTypeException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct(sprintf('Exception message: %s', $message));
    }
}