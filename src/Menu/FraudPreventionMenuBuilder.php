<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Menu;

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
        ;

        $rootMenuItem
            ->addChild(self::BLACKLISTING_RULE_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_blacklisting_rule_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.blacklisting_rules')
            ->setLabelAttribute('icon', 'hand paper')
        ;

        $rootMenuItem
            ->addChild(self::AUTOMATIC_BLACKLISTING_CONFIGURATION_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_automatic_blacklisting_configuration_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.automatic_blacklisting_configurations')
            ->setLabelAttribute('icon', 'microchip')
        ;

        $rootMenuItem
            ->addChild(self::FRAUD_SUSPICION_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_fraud_suspicion_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.fraud_suspicions')
            ->setLabelAttribute('icon', 'exclamation triangle')
        ;

        $rootMenuItem
            ->addChild(self::AUTOMATIC_BLACKLISTING_CONFIGURATION_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_automatic_blacklisting_configuration_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.automatic_blacklisting_configurations')
            ->setLabelAttribute('icon', 'cog')
        ;
    }
}
