<?php

namespace Sherlockode\Sylius\WishlistBundle\Resolver;

use Symfony\Component\HttpFoundation\Request;

interface ProductVariantCartResolverInterface
{
    /**
     * @param Request $request
     */
    public function resolve(Request $request);
}
