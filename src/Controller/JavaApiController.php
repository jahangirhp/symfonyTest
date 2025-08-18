<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JavaApiController extends AbstractController
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/form', name: 'java_form')]
    public function form(Request $request): Response
    {
        $data = ['name' => ''];

        $form = $this->createFormBuilder($data)
            ->add('name', TextType::class, ['label' => 'Your Name'])
            ->add('submit', SubmitType::class, ['label' => 'Send'])
            ->getForm();

        $form->handleRequest($request);

        $apiResponse = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            // Call Java API POST endpoint
            $response = $this->client->request('POST', 'http://localhost:8080/greet', [
                'json' => ['name' => $formData['name']]
            ]);

            $apiResponse = $response->getContent();
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'apiResponse' => $apiResponse
        ]);
    }
}
