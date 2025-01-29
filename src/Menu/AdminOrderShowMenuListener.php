<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Menu;

use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\Component\Core\Model\OrderInterface;

final class AdminOrderShowMenuListener
{
    /** @var string */
    public const MARK_SUSPICIOUS_TYPE_MENU_KEY = 'mark_suspicious';

    public function __construct(
        private readonly FraudSuspicionRepositoryInterface $fraudSuspicionRepository,
        private readonly array $rules
    ) {}

    public function addAdminOrderShowMenuItems(MenuBuilderEvent $event): void
    {
        /** @var OrderInterface $order */
        $order = $event->getOrder();

        if (null === $this->fraudSuspicionRepository->findOneByOrder($order)) {
            $menu = $event->getMenu();
            $menu
                ->addChild(self::MARK_SUSPICIOUS_TYPE_MENU_KEY, [
                    'route' => 'bitbag_sylius_blacklist_plugin_admin_order_mark_suspicious',
                    'routeParameters' => ['orderId' => $order->getId()],
                ])
                ->setLabel('bitbag_sylius_blacklist_plugin.ui.mark_suspicious')
                ->setLabelAttribute('icon', 'warning')
                ->setLabelAttribute('color', 'red');
        }
    }
}
