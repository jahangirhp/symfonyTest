<?php

// src/Controller/OrderController.php
namespace App\Controller;

use App\Entity\Orders;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/', name:'order_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $orders = $em->getRepository(Orders::class)->findAll();
        return $this->render('order/index.html.twig', ['orders' => $orders]);
    }

    #[Route('/new', name:'order_new')]
    public function new(EntityManagerInterface $em): Response
    {
        $order = new Orders();
        $order->setTitle('Sample Order')->setAmount(100.0);
        $em->persist($order);
        $em->flush();
        $this->addFlash('success', 'Order created in draft!');
        return $this->redirectToRoute('order_index');
    }

    #[Route('/{id}/transition/{transition}', name:'order_transition')]
    public function transition(Orders $order, string $transition, WorkflowInterface $order_workflow, EntityManagerInterface $em): Response
    {
        if ($order_workflow->can($order, $transition)) {
            $order_workflow->apply($order, $transition);
            $em->flush();
            $this->addFlash('success', "Transition '$transition' applied!");
        } else {
            $this->addFlash('error', "Cannot apply transition '$transition'");
        }
        return $this->redirectToRoute('order_index');
    }
}
