<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/add', name: 'app_product_add')]
    public function createProduct(EntityManagerInterface $entityManager,productRepository $productRepository,ValidatorInterface $validator): Response
    {
        $product = new Product();
        $product->setCode(12153);
        $entityManager->persist($product);
        $entityManager->flush();

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
       $products= $productRepository->findAll();

        $data = [];
        foreach ($products as $prod) {
            $data[] = [
                'id' => $prod->getId(),
                'code' => $prod->getcode(),
            ];
        }

        // Generate HTML table directly in the controller
        $html = '<table border="1"><tr><th>ID</th><th>Name</th><th>code</th></tr>';
        foreach ($data as $prod) {
            $html .= sprintf(
                '<tr><td>%d</td><td>%s</td><td>%s</td></tr>',
                $prod['id'],
                htmlspecialchars($prod['id'], ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($prod['code'], ENT_QUOTES, 'UTF-8')
            );
        }
        $html .= '</table>';

        return new Response($html);

    }
}
