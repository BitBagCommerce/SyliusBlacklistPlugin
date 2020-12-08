<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Menu;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class AdminCustomerShowMenuListener
{
    /** @var string */
    public const MARK_BLACKLISTED_TYPE_MENU_KEY = 'mark_blacklisted';

    /** @var string */
    public const MARK_NEUTRAL_TYPE_MENU_KEY = 'mark_neutral';

    /** @var CsrfTokenManagerInterface */
    private $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function addAdminCustomerShowMenuItems(MenuBuilderEvent $event): void
    {
        /** @var CustomerInterface $customer */
        $customer = $event->getCustomer();
        $menu = $event->getMenu();

        $csrfToken = $this->csrfTokenManager->getToken((string) $customer->getId())->getValue();

        if ($customer->getFraudStatus() === FraudStatusInterface::FRAUD_STATUS_NEUTRAL) {
            $menu
                ->addChild(self::MARK_BLACKLISTED_TYPE_MENU_KEY, [
                    'route' => 'bitbag_sylius_blacklist_plugin_admin_customer_mark_blacklisted',
                    'routeParameters' => [
                        'id' => $customer->getId(),
                        '_csrf_token' => $csrfToken
                    ],
                ])
                ->setAttribute('type', 'transition')
                ->setLabel('bitbag_sylius_blacklist_plugin.ui.mark_blacklisted')
                ->setLabelAttribute('icon', 'warning')
                ->setLabelAttribute('color', 'red')
            ;
        }

        if ($customer->getFraudStatus() === FraudStatusInterface::FRAUD_STATUS_BLACKLISTED) {
            $menu
                ->addChild(self::MARK_NEUTRAL_TYPE_MENU_KEY, [
                    'route' => 'bitbag_sylius_blacklist_plugin_admin_customer_mark_neutral',
                    'routeParameters' => [
                        'id' => $customer->getId(),
                        '_csrf_token' => $csrfToken
                    ],
                ])
                ->setAttribute('type', 'transition')
                ->setLabel('bitbag_sylius_blacklist_plugin.ui.mark_neutral')
                ->setLabelAttribute('icon', 'universal access')
            ;
        }
    }
}
