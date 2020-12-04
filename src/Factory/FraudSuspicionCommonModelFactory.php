<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Factory;

use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;

class FraudSuspicionCommonModelFactory implements FraudSuspicionCommonModelFactoryInterface
{
    public function createNew(): FraudSuspicionCommonModelInterface
    {
        return new FraudSuspicionCommonModel();
    }
}