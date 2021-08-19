<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Checker\FraudSuspicion;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolverInterface;
use Sylius\Component\Order\Model\OrderInterface;

final class FraudSuspicionActionEligibilityChecker implements FraudSuspicionActionEligibilityCheckerInterface
{
    /** @var FraudSuspicionRepositoryInterface */
    private $fraudSuspicionRepository;

    /** @var CustomerStateResolverInterface */
    private $customerStateResolver;

    public function __construct(
        FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        CustomerStateResolverInterface $customerStateResolver
    ) {
        $this->fraudSuspicionRepository = $fraudSuspicionRepository;
        $this->customerStateResolver = $customerStateResolver;
    }

    public function canAddFraudSuspicion(
        OrderInterface $order,
        AutomaticBlacklistingConfigurationInterface $automaticBlacklistingConfiguration
    ): bool {
        if (null !== $this->fraudSuspicionRepository->findOneBy(['order' => $order])) {
            return false;
        }

        $date = (new \DateTime())->modify('- ' . $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsTime());

        $customer = $order->getCustomer();

        $lastFraudSuspicionsOfCustomer = $this->fraudSuspicionRepository->countByCustomerAndCommentAndDate(
            $customer,
            FraudSuspicionInterface::AUTO_GENERATED_STATUS,
            $date
        );

        if (intval($lastFraudSuspicionsOfCustomer) >= $automaticBlacklistingConfiguration->getPermittedFraudSuspicionsNumber()) {
            $this->customerStateResolver->changeStateOnBlacklisted($customer);

            return false;
        }

        return true;
    }
}
