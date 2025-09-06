<?php

namespace App\Controller;

use App\DTO\ValidationDTO;
use App\Service\BankAccount;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class BankAccountController extends AbstractController
{
    #[Route('/bank/account', name: 'app_bank_account')]
    public function index(): Response
    {
        $validationDTO = new ValidationDTO();
        $validationDTO->message="test";
        return $this->render('bank_account/index.html.twig', [
            'controller_name' => 'BankAccountController',
            'dto'=>$validationDTO
        ]);
    }

    #[Route('/bank/validation', name: 'app_bankAccount_validation', methods: ['POST'])]
    public function validation(Request $request,BankAccount $bankAccount): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $IBAN = $data['IBAN'];
        $validation= $bankAccount->IBANValidation($IBAN);

        return $this->json([
             'msg' => $validation->message,

        ]);
    }
}
