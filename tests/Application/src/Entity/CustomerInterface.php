<?php

namespace Tests\BitBag\SyliusBlacklistPlugin\Entity;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use Sylius\Component\Core\Model\CustomerInterface as BaseCustomerInterface;

interface CustomerInterface extends BaseCustomerInterface, FraudStatusInterface
{

}
