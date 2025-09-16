<?php

namespace App\Controller;


use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'cart_checkout')]
    public function index(Request $request, CartService $cartService): Response
    {
        $session = $request->getSession();
        // Load products from DB
        $cartItems = $cartService->getCartItems($session);
        // Render partial Twig template for modal body
        return $this->render('checkout/index.html.twig', [
            'cartItems' => $cartItems,
        ]);
    }
}
