<?php

namespace App\Controller;

use App\Entity\JobTask;
use App\Repository\JobTaskRepository;
use App\Service\CurrencyConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class JobTaskController extends AbstractController
{
    #[Route('/job/task/list', name: 'app_job_task')]
    public function list( JobTaskRepository $jobTaskRepository): Response
    {
        $jobTasks = $jobTaskRepository->findAll();return $this->render('job_task/index.html.twig', [
            'jobTasks' => $jobTasks,
            'controller_name' => 'JobTaskController',
        ]);
    }

    #[Route('/job/task/add', name: 'app_job_task_add',methods: ['POST'])]
    public function add(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
             try {
                 $data = json_decode($request->getContent(), true);
                 $title = $data['title'];
                 $description = $data['description'];
                 $jobTask = new JobTask($title, $description);
                 $entityManager->persist($jobTask);
                 $entityManager->flush($jobTask);

            return new JsonResponse([
                'success' => true,
                'message' => 'task added successfully!'
            ], 201);

        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Failed to add task',
                'error'   => $e->getMessage(), // remove in prod
            ], 500);
        }
    }

    #[Route('/job/task/{id}', name: 'app_job_task_done',methods: ['PATCH'])]
    public function markJobComplete(JobTask $jobTask, EntityManagerInterface  $entityManager,int $id): JsonResponse
    {
        try {

           $jobTask->setIsCompleted(true);
           $entityManager->flush($jobTask);

              return new JsonResponse([
                'success' => true,
                'message' => 'task is Done!'
            ], 201);

        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Failed to done task',
                'error'   => $e->getMessage(), // remove in prod
            ], 500);
        }
    }

    #[Route('/job/task/{id}', name: 'app_job_task_delete',methods: ['DELETE'])]
    public function delete(JobTask $jobTask, EntityManagerInterface  $entityManager,int $id): JsonResponse
    {
        try {
            $entityManager->remove($jobTask);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'task is Done!'
            ], 201);

        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Failed to done task',
                'error'   => $e->getMessage(), // remove in prod
            ], 500);
        }
    }
}

