<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

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
        private CustomerStateResolverInterface $customerStateResolver,
    ) {
    }

    public function canAddFraudSuspicion(
        OrderInterface $order,
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration,
    ): bool {
        if (null !== $this->fraudSuspicionRepository->findOneBy(['order' => $order])) {
            return false;
        }

        $date = (new \DateTime())->modify('-' . $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime());
        $customer = $order->getCustomer();

        $lastFraudSuspicionsOfCustomer = $this->fraudSuspicionRepository->countByCustomerAndCommentAndDate(
            $customer,
            FraudSuspicionInterface::AUTO_GENERATED_STATUS,
            $date,
        );

        if ((int) $lastFraudSuspicionsOfCustomer >= $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()) {
            $this->customerStateResolver->changeStateOnBlacklisted($customer);

            return false;
        }

        return true;
    }
}
