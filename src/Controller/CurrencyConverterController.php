<?php

namespace App\Controller;

use App\Service\CurrencyConverter;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Intl\Currencies;

final class CurrencyConverterController extends AbstractController
{
    #[Route('/currency/converter', name: 'app_currency_converter', methods: ['GET'])]
    public function index(LoggerInterface $logger): Response
    {
        // Get all ISO 4217 currencies: ['USD' => 'US Dollar', 'EUR' => 'Euro', ...]
        $logger->info('Currency Converter start');
        $currencies = Currencies::getNames();
        return $this->render('currency_converter/index.html.twig', [
            'controller_name' => 'CurrencyConverterController',
            'currencies' => $currencies
        ]);
    }

        #[Route('/currency/convert', name: 'app_currency_convert',methods: [ 'POST'])]
        public function convert(Request $request): JsonResponse
        {
            $data = json_decode($request->getContent(), true);
            $from = $data['from'];
            $to = $data['to'];
            $amount = $data['amount'];
            $curr = new currencyConverter();
            $result= $curr->convert($from, $to, $amount);
           return $this->json([
                'result' => $result,
            ]);
        }
}
