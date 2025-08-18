<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UserType;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function createUser(EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setName('John Doe');
        $user->setEmail('john.doe@example.com');

        $entityManager->persist($user);
        $entityManager->flush();

        $res=new Response("new user is created");

        return $res;
    }

        #[Route('/user/new', name: 'user_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_new'); // Or another route
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     #[Route('/user/get', name: 'get')]
    public function get(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ];
        }

        // Generate HTML table directly in the controller
        $html = '<table border="1"><tr><th>ID</th><th>Name</th><th>Email</th></tr>';
        foreach ($data as $user) {
            $html .= sprintf(
            '<tr><td>%d</td><td>%s</td><td>%s</td></tr>',
            $user['id'],
            htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8')
            );
        }
        $html .= '</table>';

        return new Response($html);
    }
    
}
