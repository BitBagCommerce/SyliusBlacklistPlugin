<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace BitBag\SyliusBlacklistPlugin\Menu;

use BitBag\SyliusBlacklistPlugin\Repository\FraudSuspicionRepositoryInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\Component\Core\Model\OrderInterface;

final class AdminOrderShowMenuListener
{
    /** @var string */
    public const MARK_SUSPICIOUS_TYPE_MENU_KEY = 'mark_suspicious';

    /** @var FraudSuspicionRepositoryInterface */
    private $fraudSuspicionRepository;

    public function __construct(FraudSuspicionRepositoryInterface $fraudSuspicionRepository)
    {
        $this->fraudSuspicionRepository = $fraudSuspicionRepository;
    }

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
