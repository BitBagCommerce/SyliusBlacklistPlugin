<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class FraudPreventionMenuBuilder
{
    public const AUTOMATIC_BLACKLISTING_CONFIGURATION_TYPE_MENU_KEY = 'automatic_blacklisting_configuration';

    public const BLACKLISTING_RULE_TYPE_MENU_KEY = 'blacklisting_rule';

    public const FRAUD_SUSPICION_TYPE_MENU_KEY = 'fraud_suspicion';

    public function buildMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();

        $rootMenuItem = $menu
            ->addChild('bitbag_fraud_prevention')
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.fraud_prevention')
            ->setLabelAttribute('icon', 'spy')
        ;

        $rootMenuItem
            ->addChild(self::BLACKLISTING_RULE_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_blacklisting_rule_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.blacklisting_rules')
        ;

        $rootMenuItem
            ->addChild(self::AUTOMATIC_BLACKLISTING_CONFIGURATION_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_automatic_blacklisting_configuration_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.automatic_blacklisting_configurations')
        ;

        $rootMenuItem
            ->addChild(self::FRAUD_SUSPICION_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_fraud_suspicion_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.fraud_suspicions')
        ;

        $rootMenuItem
            ->addChild(self::AUTOMATIC_BLACKLISTING_CONFIGURATION_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_automatic_blacklisting_configuration_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.automatic_blacklisting_configurations')
        ;
    }
}
