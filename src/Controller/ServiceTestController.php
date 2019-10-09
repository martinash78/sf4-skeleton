<?php
namespace App\Controller;

use App\Service\MessageGenerator;
use App\Service\EmailSender;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceTestController extends AbstractController
{

    public function new(MessageGenerator $messageGenerator)
    {
        $message = $messageGenerator->getChuckMessage();
        return new Response(
            $message
        );
    }

    public function email(EmailSender $emailSender)
    {
        return new Response(
            $emailSender->sendEmail()
        );

    }
}