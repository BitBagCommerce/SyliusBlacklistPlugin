<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Entity;

use BitBag\SyliusBlacklistPlugin\Model\FraudStatusTrait;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

class Customer extends BaseCustomer implements CustomerInterface
{
    use FraudStatusTrait;
}
