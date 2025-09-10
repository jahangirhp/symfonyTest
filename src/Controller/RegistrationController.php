<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET','POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $name = $request->request->get('name');
            $plainPassword = $request->request->get('password');

            if (!$email || !$plainPassword) {
                return new Response('Email and password are required', Response::HTTP_BAD_REQUEST);
            }

            $user = new User();
            $user->setEmail($email);
            $user->setName($name);
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig');
    }

    #[Route('/register/changePassword', name: 'app_register_changePassword', methods: ['GET','POST'])]
    public function changePassword(Request $request,
                                   UserPasswordHasherInterface $passwordHasher,
                                   EntityManagerInterface $entityManager,
                                   UserRepository $userRepository ): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $user = $userRepository->findOneBy(['email' => $email]);
            $passwordHasher->hashPassword($user, $password);
            return new Response('Password Changed Successfully');
        }

        return $this->render('registration/changePass.html.twig');
    }
}
