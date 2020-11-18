<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Entity;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\CustomerInterface;
use BitBag\SyliusBlacklistPlugin\Model\CustomerTrait;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

class Customer extends BaseCustomer implements CustomerInterface
{
    use CustomerTrait;
}
