<?php

namespace App\Service;
use App\DTO\CartItemDTO;
use App\Repository\ProductRepository;

class CartManager
{
    public function getCartItems($session, ProductRepository $repo) :array
    {
        $cart = $session->get('cart', []); // [productId => quantity]

        // Load products from DB
        $cartItems = [];
        foreach ($cart as $id => $qty) {
            $product = $repo->find($id);
            if ($product) {
                $cartItems[] =new CartItemDTO($product->getId(),$product->getName(),$product->getPrice(), $qty);
            }
        }
        return $cartItems;
    }
}
