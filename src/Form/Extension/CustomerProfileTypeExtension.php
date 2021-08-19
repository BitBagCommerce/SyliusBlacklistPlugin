<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Form\Extension;

use BitBag\SyliusBlacklistPlugin\Checker\UserRoleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use Sylius\Bundle\CustomerBundle\Form\Type\CustomerProfileType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class CustomerProfileTypeExtension extends AbstractTypeExtension
{
    /** @var UserRoleCheckerInterface */
    private $userRoleChecker;

    public function __construct(UserRoleCheckerInterface $userRoleChecker)
    {
        $this->userRoleChecker = $userRoleChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fraudStatus', ChoiceType::class, [
               'choices' => [
                   'bitbag_sylius_blacklist_plugin.ui.neutral' => FraudStatusInterface::FRAUD_STATUS_NEUTRAL,
                   'bitbag_sylius_blacklist_plugin.ui.blacklisted' => FraudStatusInterface::FRAUD_STATUS_BLACKLISTED,
                   'bitbag_sylius_blacklist_plugin.ui.whitelisted' => FraudStatusInterface::FRAUD_STATUS_WHITELISTED,
               ],
                'mapped' => $this->userRoleChecker->isAdmin(),
            ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [CustomerProfileType::class];
    }
}
