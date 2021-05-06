<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Form\Extension;

use BitBag\SyliusBlacklistPlugin\Checker\UserRoleCheckerInterface;
use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use Sylius\Bundle\CustomerBundle\Form\Type\CustomerProfileType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomerProfileTypeExtension extends AbstractTypeExtension
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
                   'bitbag_sylius_blacklist_plugin.ui.whitelisted' => FraudStatusInterface::FRAUD_STATUS_WHITELISTED
               ],
                'mapped' => $this->userRoleChecker->isAdmin()
            ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [CustomerProfileType::class];
    }
}