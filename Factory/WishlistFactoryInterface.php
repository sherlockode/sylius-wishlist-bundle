<?php

namespace Sherlockode\Sylius\WishlistBundle\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Model\UserInterface;
use Sherlockode\Sylius\WishlistBundle\Model\WishlistInterface;

interface WishlistFactoryInterface extends FactoryInterface
{
    /**
     * @param UserInterface $user
     *
     * @return WishlistInterface
     */
    public function createDefault(UserInterface $user);
}
