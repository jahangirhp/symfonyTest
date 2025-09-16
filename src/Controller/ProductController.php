<?php

namespace App\Controller;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product/admin', name: 'app_products',methods: ['POST','GET'])]
    public function list( Request $request, EntityManagerInterface $em,
                           ProductRepository $productRepository,FileUploader $fileUploader
    ): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        $imageFile = $form->get('imgUrl')->getData();

        if ($imageFile) {
            $newFilename = $fileUploader->upload($imageFile);
            $product->setImgUrl($newFilename);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Product added with Form!');
        }

        $products = $productRepository->findAll();
        return $this->render('product/admin/list.html.twig', [
            'form' => $form->createView(),
            'products' => $products,
        ]);
    }

    #[Route('/product/list', name: 'app_product_list_user',methods: ['GET'])]
    public function list_product_user( ProductRepository $productRepository,Request $request): Response
    {
        $filter = $request->get('name');
        if ($filter) {
            $products = $productRepository->findByName($filter);
        } else {
            $products = $productRepository->findAll();
        }

        return $this->render('product/product_list.html.twig', [
            'products' => $products,
            'filter' => $filter,
        ]);
    }
    #[Route('/product/admin/{id}', name: 'app_product_delete',methods: ['POST'])]
    public function delete(Product $product, EntityManagerInterface  $entityManager,Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash('success', 'Product deleted successfully');
        }
        return $this->redirectToRoute('app_products');
    }


}
