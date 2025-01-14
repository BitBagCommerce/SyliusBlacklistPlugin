<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Checker\FraudSuspicion;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Sylius\Component\Order\Model\OrderInterface;

final class FraudSuspicionActionEligibilityChecker implements FraudSuspicionActionEligibilityCheckerInterface
{
    public function __construct(
        private FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        private CustomerStateResolverInterface $customerStateResolver
    ) {}

    public function canAddFraudSuspicion(
        OrderInterface $order,
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration
    ): bool {
        if ($this->fraudSuspicionRepository->findOneBy(['order' => $order]) !== null) {
            return false;
        }

        $date = (new \DateTime())->modify('-' . $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime());
        $customer = $order->getCustomer();

        $lastFraudSuspicionsOfCustomer = $this->fraudSuspicionRepository->countByCustomerAndCommentAndDate(
            $customer,
            FraudSuspicionInterface::AUTO_GENERATED_STATUS,
            $date
        );

        if ($lastFraudSuspicionsOfCustomer >= $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()) {
            $this->customerStateResolver->changeStateOnBlacklisted($customer);

            return false;
        }

        return true;
    }
}
