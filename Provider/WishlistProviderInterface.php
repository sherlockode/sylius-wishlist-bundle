<?php

namespace Sherlockode\Sylius\WishlistBundle\Provider;

use Sherlockode\Sylius\WishlistBundle\Model\WishlistInterface;

interface WishlistProviderInterface
{
    /**
     * @return WishlistInterface[]
     */
    public function getWishlists();

    /**
     * @return int
     */
    public function getItemCount();
}
