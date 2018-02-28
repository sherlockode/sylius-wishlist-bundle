<?php

namespace Sherlockode\Sylius\WishlistBundle\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class MenuBuilderListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addBackendMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        // Get or create the parent group
        if (null == ($contentMenu = $menu->getChild('customers'))) {
            $contentMenu = $menu->addChild('customers')->setLabel('sherlockode_wishlist.ui.customer');
        }

        // Add 'Wishlists' menu item
        $contentMenu->addChild('sherlockode_wishlists', ['route' => 'sherlockode_wishlist_admin_wishlist_index'])
                    ->setLabel('sherlockode_wishlist.ui.wishlists')
                    ->setLabelAttribute('icon', 'star');
    }
}
