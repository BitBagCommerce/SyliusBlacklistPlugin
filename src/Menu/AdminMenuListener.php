<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public const AUTOMATIC_BLACKLISTING_CONFIGURATION_TYPE_MENU_KEY = 'automatic_blacklisting_configuration';

    public const BLACKLISTING_RULE_TYPE_MENU_KEY = 'blacklisting_rule';

    public const FRAUD_SUSPICION_TYPE_MENU_KEY = 'fraud_suspicion';

    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $this->addToCatalogMenu($menu);
    }

    private function addToCatalogMenu(ItemInterface $menu): void
    {
        $salesMenu = $menu->getChild('sales');

        $salesMenu
            ->addChild(self::BLACKLISTING_RULE_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_blacklisting_rule_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.blacklisting_rules')
            ->setLabelAttribute('icon', 'hand paper');

        $salesMenu
            ->addChild(self::AUTOMATIC_BLACKLISTING_CONFIGURATION_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_automatic_blacklisting_configuration_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.automatic_blacklisting_configurations')
            ->setLabelAttribute('icon', 'microchip');

        $salesMenu
            ->addChild(self::FRAUD_SUSPICION_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_fraud_suspicion_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.fraud_suspicions')
            ->setLabelAttribute('icon', 'exclamation triangle');

        $salesMenu
            ->addChild(self::AUTOMATIC_BLACKLISTING_CONFIGURATION_TYPE_MENU_KEY, [
                'route' => 'bitbag_sylius_blacklist_plugin_admin_automatic_blacklisting_configuration_index',
            ])
            ->setLabel('bitbag_sylius_blacklist_plugin.ui.automatic_blacklisting_configurations')
            ->setLabelAttribute('icon', 'cog');
    }
}
