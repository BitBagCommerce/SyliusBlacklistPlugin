<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Checker\FraudSuspicion;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use Sylius\Component\Order\Model\OrderInterface;

interface FraudSuspicionActionEligibilityCheckerInterface
{
    public function canAddFraudSuspicion(OrderInterface $order, AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration): bool;
}
