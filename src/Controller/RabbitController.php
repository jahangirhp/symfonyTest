<?php

namespace App\Controller;

use App\Message\EmailNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class RabbitController extends AbstractController
{
    #[Route('/send', name: 'send_message')]
    public function send(MessageBusInterface $bus): Response
    {
        $bus->dispatch(new EmailNotification("Hello from Symfony to RabbitMQ!"));

        return new Response("Message sent to RabbitMQ!");
    }
}
