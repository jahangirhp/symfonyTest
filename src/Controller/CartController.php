<?php
// src/Controller/CartController.php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(int $id, Request $request): JsonResponse
    {

        $session = $request->getSession();
        $cart = $session->get('cart', []);

        // Add or update product quantity
        $cart[$id] = ($cart[$id] ?? 0) + 1;

        $session->set('cart', $cart);

        return $this->json([
            'success' => true,
            'message' => ' added to cart!',
            'cartCount' => array_sum($cart),
        ]);
    }


// src/Controller/CartController.php
    #[Route('/cart/modal', name: 'cart_modal')]
    public function view(Request $request, CartService $cartService): Response
    {
        $session = $request->getSession();

        // Load products from DB
        $cartItems = $cartService->getCartItems($session);
        // Render partial Twig template for modal body
        return $this->render('cart/_cart_item.html.twig', [
            'cartItems' => $cartItems,
        ]);
    }
}

