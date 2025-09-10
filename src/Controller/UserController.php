<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function createUser(EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setName('John Doe');
        $user->setEmail('john2.doe@example.com');

        $entityManager->persist($user);
        $entityManager->flush();

        $res=new Response("new user is created");

        return $res;
    }

    #[Route('/user/admin/{id}', name: 'app_user_admin', methods: ['PATCH'])]
    public function makeUserAdmin(User $user,EntityManagerInterface $entityManager): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Add ROLE_ADMIN
        $user->addRole('ROLE_ADMIN');

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('User is now an admin!');
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
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'controller_name' => 'UserController',
        ]);

    }

      #[Route('/api/users/get', name: 'api_users_get')]
    public function apiGet(EntityManagerInterface $entityManager): Response
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

        return new JsonResponse($data);
    }

    #[Route('/jsApi', name: 'js_api')]
    public function getByJs(): Response
    {
        // Render the Twig template
        return $this->render('user/getUserByJs.html.twig');
    }

}
