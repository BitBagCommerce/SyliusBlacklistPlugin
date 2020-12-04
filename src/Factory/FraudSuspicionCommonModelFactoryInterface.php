<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Factory;

use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface FraudSuspicionCommonModelFactoryInterface extends FactoryInterface
{
    public function createNew(): FraudSuspicionCommonModelInterface;
}

