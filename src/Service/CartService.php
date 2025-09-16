<?php

namespace App\Service;
use App\DTO\CartItemDTO;
use App\Repository\ProductRepository;

class CartService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function getCartItems($session, ) :array
    {

        $cart = $session->get('cart', []); // [productId => quantity]

        // Load products from DB
        $cartItems = [];
        foreach ($cart as $id => $qty) {
            $product = $this->productRepository->find($id);
            if ($product) {
                $cartItems[] =new CartItemDTO($product,$qty);
            }
        }
        return $cartItems;
    }
}
