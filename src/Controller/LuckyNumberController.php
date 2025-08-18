<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LuckyNumberController extends AbstractController
{
    
    public function index(): Response
    {
        $res = random_int(0, 100);
        return $this->render('lucky_number/index.html.twig', [
            'controller_name' => 'LuckyNumberController',
            'lucky_number' => $res,
        ]);
    }
}
