<?php

namespace Sherlockode\Sylius\WishlistBundle\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Sherlockode\Sylius\WishlistBundle\Repository\WishlistRepositoryInterface;

class AccountMenuBuilderListener
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var WishlistRepositoryInterface
     */
    protected $wishlistRepository;

    /**
     * @var bool
     */
    protected $multipleWishlistMode;

    /**
     * FrontendMenuBuilderListener constructor.
     *
     * @param TranslatorInterface $translator
     * @param TokenStorageInterface $tokenStorage
     * @param WishlistRepositoryInterface $wishlistRepository
     * @param $multipleWishlistMode
     */
    public function __construct(
        TranslatorInterface $translator,
        TokenStorageInterface $tokenStorage,
        WishlistRepositoryInterface $wishlistRepository,
        $multipleWishlistMode
    ) {

        $this->translator = $translator;
        $this->tokenStorage = $tokenStorage;
        $this->wishlistRepository = $wishlistRepository;
        $this->multipleWishlistMode = $multipleWishlistMode;
    }

    /**
     * Add menu items for the account section.
     *
     * @param MenuBuilderEvent $event
     */
    public function addAccountMenuItems(MenuBuilderEvent $event)
    {
        // Get the menu
        $menu = $event->getMenu();

        // Set route and label, depending on multiple wishlist mode
        if ($this->multipleWishlistMode) {
            $route = 'sherlockode_account_wishlist_index';
            $routeParameters = [];
            $label = $this->translate('sherlockode_wishlist.ui.my_wishlists');
        } else {
            // Get the first wishlist for the user
            $wishlist = $this->wishlistRepository->getFirstForUser($this->getUser());

            if (!$wishlist) {
                return;
            }

            $route = 'sherlockode_account_wishlist_edit';
            $routeParameters = [
                'id' => $wishlist->getId()
            ];
            $label = $this->translate('sherlockode_wishlist.ui.my_wishlist');
        }

        // Add menu item to the menu
        $menu->addChild('wishlists', [
            'route' => $route,
            'routeParameters' => $routeParameters,
            'linkAttributes' => ['title' => $label],
            'labelAttributes' => ['icon' => 'star', 'iconOnly' => false],
        ])->setLabel($label);
    }

    /**
     * Translate a string using the translator.
     *
     * @param $string
     * @return string
     */
    protected function translate($string)
    {
        return $this->translator->trans($string);
    }

    /**
     * @return UserInterface
     */
    protected function getUser()
    {
        if ($securityToken = $this->tokenStorage->getToken()) {
            if (($user = $securityToken->getUser()) instanceof UserInterface) {
                return $user;
            }
        }

        return null;
    }
}
